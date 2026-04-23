<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\InterviewQuestionAnswer;
use App\Models\InterviewTopic;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function index()
    {
        $topics = InterviewTopic::where('status', 1)
            ->withCount(['questions' => fn($q) => $q->where('status', 1)])
            ->orderByRaw("CASE WHEN topic = 'ALL TOPICS' THEN 0 ELSE 1 END")
            ->orderBy('topic', 'asc')
            ->get();

        return view('user.interview.index', compact('topics'));
    }

    public function getQuestions($id)
    {
        $questions = InterviewQuestionAnswer::where('topic_id', $id)
            ->where('status', 1)
            ->orderBy('id', 'asc')
            ->get(['id', 'question', 'question_image', 'answer', 'answer_image', 'type'])
            ->map(function ($q) {
                return [
                    'id'             => $q->id,
                    'question'       => $q->question,
                    'question_image' => $q->question_image,
                    'answer'         => $q->answer,
                    'answer_image'   => $q->answer_image,
                    'type'           => $q->type,
                ];
            });

        return response()->json($questions);
    }

    public function show($id)
    {
        $topic = InterviewTopic::findOrFail($id);
        $questions = InterviewQuestionAnswer::where('topic_id', $id)->where('status', 1)->inRandomOrder()->get();

        return view('user.interview.show', compact('topic', 'questions'));
    }
}
