<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForumComment;
use App\Models\ForumLike;
use Illuminate\Http\Request;
use App\Models\ForumTopic;
use Illuminate\Support\Facades\Validator;
use App\DataTables\ForumTopicsDataTable;
use App\DataTables\ForumDataTable;
use App\Models\Forum;
use App\Models\ForumCommentReply;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\NotificationController;

class ForumController extends Controller
{
    public function index(ForumTopicsDataTable $dataTable)
    {
        return $dataTable->render('admin.forums.topics.index');
    }

    public function topicStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        ForumTopic::create([
            'topic' => $request->topic,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('admin.forum.index')->with('success', 'Topic added successfully!');
    }

    public function topicUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'topic' => 'required|string|max:255',
            'status' => 'required|in:0,1'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $topic = ForumTopic::findOrFail($id);
        $topic->update([
            'topic' => $request->topic,
            'status' => $request->status
        ]);

        return redirect()->route('admin.forum.index')->with('success', 'Topic updated successfully!');
    }

    public function topicDestroy($id)
    {
        $topic = ForumTopic::findOrFail($id);
        $topic->delete();

        return redirect()->route('admin.forum.index')->with('success', 'Topic deleted successfully!');
    }

    public function forumIndex(ForumDataTable $dataTable)
    {
        $topics = ForumTopic::where('status', 1)->select('id', 'topic')->get();
        return $dataTable->render('admin.forums.forums.index', compact('topics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg|max:204899',
            'topics' => 'required|array',
            'topics.*' => 'exists:forum_topics,id'
        ]);

        $bannerPath = null;
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('banners', 'public');
        }

        $forum = Forum::create([
            'user_id' => Auth::id(),
            'topic_ids' => $request->topics,
            'name' => $request->name,
            'description' => $request->description,
            'banner' => $bannerPath,
            'status' => 1,
        ]);

        $message = "📢 Forum Alert! Dive in and share your thoughts on '{$forum->name}'.";

        app(NotificationController::class)->send($message, 'forum');

        return redirect()->back()->with('success', 'Community created successfully and notifications sent!');
    }

    public function show($id)
    {
        $forum = Forum::withCount('likes')->findOrFail($id);
        $topics = ForumTopic::whereIn('id', $forum->topic_ids ?? [])->pluck('topic');
        $restrictedUsers = $forum->restricted_ids ?? [];

        $comments = ForumComment::with([
            'user',
            'likes',
            'replies' => function ($query) use ($restrictedUsers) {
                $query->with(['user', 'likes'])->whereNotIn('user_id', $restrictedUsers)->take(2);
            }
        ])->where('forum_id', $forum->id)->whereNotIn('user_id', $restrictedUsers)->latest()->paginate(5);

        $forumLikes = $forum->likes()->with('user:id,name,profile_image')->take(10)->get();

        return view('admin.forums.forums.show', compact('forum', 'topics', 'comments', 'forumLikes'));
    }


    public function actionForum(Request $request)
    {
        if ($request->action === 'load_more_replies') {
            $forum = Forum::find($request->forum_id);
            if (!$forum) {
                return response()->json(['success' => false, 'message' => 'Forum not found']);
            }

            $restrictedUsers = $forum->restricted_ids ?? [];

            $replies = ForumCommentReply::where('comment_id', $request->comment_id)->whereNotIn('user_id', $restrictedUsers)->with(['user', 'likes'])->skip($request->offset)->take(3)->get();

            $renderedReplies = '';
            foreach ($replies as $reply) {
                $renderedReplies .= view('admin.forums.forums.partials.reply', [
                    'reply' => $reply,
                    'forum' => $forum
                ])->render();
            }

            return response()->json([
                'html' => $renderedReplies,
                'loaded' => $replies->count(),
                'has_more' => $replies->count() === 3
            ]);
        }

        if ($request->action === 'delete_comment') {
            $comment = ForumComment::find($request->comment_id);
            if ($comment) {
                $comment->delete();
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false]);
        }

        if ($request->action === 'delete_reply') {
            $reply = ForumCommentReply::find($request->reply_id);
            if ($reply) {
                $reply->delete();
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false]);
        }

        if ($request->action === 'restrict_user') {
            $forum = Forum::find($request->forum_id);
            if ($forum) {
                $restricted = $forum->restricted_ids ?? [];

                if (!in_array((int) $request->user_id, $restricted)) {
                    $restricted[] = (int) $request->user_id;
                }

                $forum->restricted_ids = $restricted;
                $forum->save();

                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false]);
        }

        if ($request->action === 'get_user_comments') {
            $forum = Forum::find($request->forum_id);
            $user = User::find($request->user_id);

            if (!$forum || !$user) {
                return response()->json(['html' => '<p>User not found.</p>']);
            }

            $comments = ForumComment::with('likes')->where('forum_id', $forum->id)->where('user_id', $user->id)->get();

            $replies = ForumCommentReply::with('likes')->where('user_id', $user->id)
                ->whereIn('comment_id', ForumComment::where('forum_id', $forum->id)->pluck('id'))->get();

            $html = view('admin.forums.forums.partials.restricted-user-comments', compact('comments', 'replies', 'user'))->render();

            return response()->json(['html' => $html]);
        }

        if ($request->action === 'remove_restricted_user') {
            $forum = Forum::find($request->forum_id);
            if ($forum) {
                $restricted = $forum->restricted_ids ?? [];
                $restricted = array_filter($restricted, fn($id) => $id != $request->user_id);
                $forum->restricted_ids = array_values($restricted);
                $forum->save();
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid action']);
    }

    public function forumUpdate(Request $request, $id)
    {
        $forum = Forum::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'topics' => 'required|array',
            'topics.*' => 'exists:forum_topics,id',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:0,1'
        ]);

        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('banners', 'public');
        }

        $validated['topic_ids'] = $request->topics;
        unset($validated['topics']);

        $forum->update($validated);

        return redirect()->back()->with('success', 'Forum updated successfully!');
    }

    public function forumDestroy($id)
    {
        $forum = Forum::findOrFail($id);
        $forum->delete();

        return redirect()->back()->with('success', 'Forum deleted successfully!');
    }
}
