<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InterviewTopic;
use Illuminate\Support\Facades\Validator;
use App\DataTables\InterviewTopicsDataTable;
use App\Models\InterviewQuestionAnswer;
use App\DataTables\InterviewQADataTable;

class InterviewController extends Controller
{
    public function index(InterviewTopicsDataTable $dataTable)
    {
        return $dataTable->render('admin.interviews.topics.index');
    }

    public function topicStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic' => 'required|string|max:255',
            'description' => 'required|string|max:500'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        InterviewTopic::create([
            'topic' => $request->topic,
            'description' => $request->description,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->back()->with('success', 'Topic added successfully!');
    }

    public function topicUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'topic' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'status' => 'required|in:0,1'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $topic = InterviewTopic::findOrFail($id);
        $topic->update([
            'topic' => $request->topic,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Topic updated successfully!');
    }

    public function topicDestroy($id)
    {
        $topic = InterviewTopic::findOrFail($id);
        $topic->delete();

        return redirect()->back()->with('success', 'Topic deleted successfully!');
    }

    public function interviewIndex(InterviewQADataTable $dataTable)
    {
        $topics = InterviewTopic::where('status', 1)->orderBy('topic', 'asc')->get();

        return $dataTable->render('admin.interviews.index', compact('topics'));
    }

    public function store(Request $request)
    {
        $rules = [
            'topic_id' => 'required|exists:interview_topics,id',
            'type' => 'required|in:QA,MSQ',
            'question' => 'required|string',
        ];

        if ($request->type === 'QA') {
            $rules['qa_answer'] = 'required|string';
        }

        if ($request->type === 'MSQ') {
            $rules['option_a'] = 'required|string';
            $rules['option_b'] = 'required|string';
            $rules['option_c'] = 'required|string';
            $rules['option_d'] = 'required|string';
            $rules['mcq_answer'] = 'required|in:a,b,c,d';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'topic_id' => $request->topic_id,
            'type' => $request->type,
            'question' => $request->question,
            'status' => $request->status ?? 1,
        ];

        if ($request->type === 'QA') {
            $data['answer'] = $request->qa_answer;
            $data['options'] = null;
        } else {
            $data['options'] = json_encode([
                'a' => $request->option_a,
                'b' => $request->option_b,
                'c' => $request->option_c,
                'd' => $request->option_d,
            ]);
            $data['answer'] = $request->mcq_answer;
        }

        InterviewQuestionAnswer::create($data);

        return redirect()->back()->with('success', 'Interview question added successfully!');
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'topic_id' => 'required|exists:interview_topics,id',
            'type' => 'required|in:QA,MSQ',
            'question' => 'required|string',
            'status' => 'required|in:0,1'
        ];

        if ($request->type === 'QA') {
            $rules['qa_answer'] = 'required|string';
        }

        if ($request->type === 'MSQ') {
            $rules['option_a'] = 'required|string';
            $rules['option_b'] = 'required|string';
            $rules['option_c'] = 'required|string';
            $rules['option_d'] = 'required|string';
            $rules['mcq_answer'] = 'required|in:a,b,c,d';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $question = InterviewQuestionAnswer::findOrFail($id);

        $data = [
            'topic_id' => $request->topic_id,
            'type' => $request->type,
            'question' => $request->question,
            'status' => $request->status,
        ];

        if ($request->type === 'QA') {
            $data['answer'] = $request->qa_answer;
            $data['options'] = null;
        } else {
            $data['options'] = json_encode([
                'a' => $request->option_a,
                'b' => $request->option_b,
                'c' => $request->option_c,
                'd' => $request->option_d,
            ]);
            $data['answer'] = $request->mcq_answer;
        }

        $question->update($data);

        return redirect()->back()->with('success', 'Interview question updated successfully!');
    }

    public function destroy($id)
    {
        $qa = InterviewQuestionAnswer::findOrFail($id);
        $qa->delete();

        return redirect()->back()->with('success', 'QA deleted successfully!');
    }
}
