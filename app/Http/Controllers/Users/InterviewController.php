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
        $topics = InterviewTopic::where('status', 1)->withCount('questions')->orderBy('topic', 'asc')->get();
        return view('user.interview.index', compact('topics'));
    }

    public function show($id)
    {
        $topic = InterviewTopic::findOrFail($id);
        $questions = InterviewQuestionAnswer::where('topic_id', $id)->where('status', 1)->inRandomOrder()->get();

        return view('user.interview.show', compact('topic', 'questions'));
    }
}
