<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\ForumTopic;
use App\Models\Forum;
use App\Models\ForumComment;
use App\Models\ForumCommentLike;
use App\Models\ForumCommentReply;
use App\Models\ForumLike;
use App\Models\ForumReplyLikes;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function index(Request $request)
    {
        $topics = ForumTopic::where('status', 1)->select('id', 'topic')->get();
        $order = $request->get('order', 'latest');

        $query = Forum::query()->where('status', 1);

        if ($order === 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        if (auth()->check()) {
            $userId = auth()->id();
            $query->where(function ($query) use ($userId) {
                $query->whereNull('restricted_ids')->orWhereJsonDoesntContain('restricted_ids', $userId);
            });
        }

        $forums = $query->paginate(6);

        if ($request->ajax()) {
            return view('user.forum.partials.forum-list', compact('forums'))->render();
        }

        return view('user.forum.index', compact('topics', 'forums', 'order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'banner' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'topic_ids' => 'required|json',
        ]);

        $bannerPath = null;
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('banners', 'public');
        }

        Forum::create([
            'user_id' => Auth::id(),
            'topic_ids' => json_decode($request->topic_ids),
            'name' => $request->name,
            'description' => $request->description,
            'banner' => $bannerPath,
            'status' => 1,
        ]);

        return redirect()->back()->with('success', 'Community created successfully!');
    }

    public function show($id)
    {
        $forum = Forum::with('user')->findOrFail($id);

        $restricted = is_array($forum->restricted_ids) ? $forum->restricted_ids : [];

        $comments = ForumComment::with([
            'user',
            'replies' => function ($query) use ($restricted) {
                $query->with('user')->when(!empty($restricted), fn($query) => $query->whereNotIn('user_id', $restricted))->latest()->take(2);
            }
        ])->where('forum_id', $forum->id)->when(!empty($restricted), fn($query) => $query->whereNotIn('user_id', $restricted))->latest()->paginate(3);

        return view('user.forum.show', compact('forum', 'comments'));
    }

    public function forumAction(Request $request)
    {
        $action = $request->action;
        $userId = Auth::id();
        $userName = Auth::user()->name;

        switch ($action) {
            case 'like_forum':
                $forum = Forum::findOrFail($request->forum_id);
                $existingLike = ForumLike::where('forum_id', $forum->id)->where('user_id', $userId)->first();

                if ($existingLike) {
                    $existingLike->delete();
                    $status = 'unliked';
                } else {
                    ForumLike::create(['forum_id' => $forum->id, 'user_id' => $userId]);
                    $status = 'liked';
                }

                return response()->json([
                    'status' => $status,
                    'likes_count' => $forum->likes()->count(),
                    'message' => $status === 'liked' ? 'Forum liked successfully!' : 'Forum unliked!'
                ]);

            case 'add_comment':
                $request->validate(['comment' => 'required|string|max:1000']);
                $forum = Forum::findOrFail($request->forum_id);

                $comment = ForumComment::create([
                    'forum_id' => $forum->id,
                    'user_id' => $userId,
                    'comment' => $request->comment
                ]);

                return response()->json([
                    'status' => 'success',
                    'comment_html' => view('user.forum.partials.comment', ['comment' => $comment->load('user')])->render(),
                    'comment_count' => $forum->comments()->count(),
                    'message' => 'Comment added successfully!'
                ]);

            case 'like_comment':
                $comment = ForumComment::findOrFail($request->comment_id);
                $existingLike = ForumCommentLike::where('comment_id', $comment->id)->where('user_id', $userId)->first();

                if ($existingLike) {
                    $existingLike->delete();
                    $status = 'unliked';
                } else {
                    ForumCommentLike::create([
                        'forum_id' => $comment->forum_id,
                        'comment_id' => $comment->id,
                        'user_id' => $userId
                    ]);
                    $status = 'liked';

                    if ($comment->user_id !== $userId) {
                        Notification::create([
                            'user_id' => $comment->user_id,
                            'type' => 'comment_like',
                            'message' => "$userName liked your comment",
                            'status' => 'delivered'
                        ]);
                    }
                }

                return response()->json([
                    'status' => $status,
                    'likes_count' => $comment->likes()->count(),
                    'message' => $status === 'liked' ? 'You liked a comment!' : 'Comment like removed!'
                ]);

            case 'add_reply':
                $request->validate([
                    'comment_id' => 'required|exists:forum_comments,id',
                    'reply' => 'required|string|max:500'
                ]);

                $comment = ForumComment::findOrFail($request->comment_id);

                $reply = ForumCommentReply::create([
                    'user_id' => $userId,
                    'forum_id' => $comment->forum_id,
                    'comment_id' => $comment->id,
                    'reply' => $request->reply
                ]);

                if ($comment->user_id !== $userId) {
                    Notification::create([
                        'user_id' => $comment->user_id,
                        'type' => 'reply',
                        'message' => "$userName replied to your comment: {$reply->reply}",
                        'status' => 'delivered'
                    ]);
                }

                return response()->json([
                    'status' => 'success',
                    'reply_html' => view('user.forum.partials.reply-item', ['reply' => $reply->load('user')])->render(),
                    'message' => 'Reply added successfully!'
                ]);

            case 'like_reply':
                $replyId = $request->reply_id;
                $reply = ForumCommentReply::findOrFail($replyId);

                $existingLike = ForumReplyLikes::where('reply_id', $replyId)->where('user_id', $userId)->first();
                if ($existingLike) {
                    $existingLike->delete();
                    $status = 'unliked';
                } else {
                    ForumReplyLikes::create([
                        'user_id' => $userId,
                        'forum_id' => $reply->forum_id,
                        'comment_id' => $reply->comment_id,
                        'reply_id' => $replyId
                    ]);
                    $status = 'liked';

                    if ($reply->user_id !== $userId) {
                        Notification::create([
                            'user_id' => $reply->user_id,
                            'type' => 'reply_like',
                            'message' => "$userName liked your reply",
                            'status' => 'delivered'
                        ]);
                    }
                }

                return response()->json([
                    'status' => $status,
                    'likes_count' => ForumReplyLikes::where('reply_id', $replyId)->count(),
                    'message' => $status === 'liked' ? 'You liked a reply!' : 'Reply like removed!'
                ]);

            case 'load_more_comments':

                $forumId = $request->forum_id;
                $page = $request->page ?? 2;
                $comments = ForumComment::with(['user', 'replies.user'])->where('forum_id', $forumId)->latest()->paginate(3, ['*'], 'page', $page);

                return response()->json(['comments_html' => view('user.forum.partials.comment-list', ['comments' => $comments])->render(), 'next_page' => $comments->nextPageUrl()]);

            case 'load_more_replies':

                $commentId = $request->comment_id;
                $offset = $request->offset ?? 2;
                $replies = ForumCommentReply::where('comment_id', $commentId)->with('user')->skip($offset)->take(3)->get();

                return response()->json(['replies_html' => view('user.forum.partials.reply-items', ['replies' => $replies])->render(), 'loaded' => $replies->count(), 'has_more' => ForumCommentReply::where('comment_id', $commentId)->count() > $offset + $replies->count()]);
                
            default:
                return response()->json(['status' => 'error', 'message' => 'Invalid action!'], 400);

        }
    }

    public function destroy($id)
    {
        $forum = Forum::findOrFail($id);
        $forum->delete();

        return redirect()->route('user.forum.index')->with(['success' => 'Channel deleted successfully.']);
    }
}
