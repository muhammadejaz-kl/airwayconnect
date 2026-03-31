<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AirlineDirectory;
use Illuminate\Http\Request;
use App\DataTables\JobsDataTable;
use App\Models\JobPost;

use App\Http\Controllers\NotificationController;

class JobPostController extends Controller
{
    public function index(JobsDataTable $dataTable)
    {
        $airlines = AirlineDirectory::orderBy('name', 'asc')->get();
        return $dataTable->render('admin.jobs.index', compact('airlines'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'for_airlines' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'last_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:100',
        ]);

        $job = JobPost::create($validated);

        $message = "💼 Career Alert: '{$job->title}' opening in {$job->location} for airlines — don’t miss out!";

        app(NotificationController::class)->send($message, 'job');

        return redirect()->route('admin.jobs.index')->with(['success' => 'Job added successfully and notifications sent!']);
    }
    public function show($id)
    {
        $job = JobPost::findOrFail($id);
        return view('admin.jobs.show', compact('job'));
    }

    public function update(Request $request, $id)
    {
        $job = JobPost::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'for_airlines' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'last_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:100',
            'status' => 'nullable|in:0,1',
        ]);

        $job->update($validated);

        return redirect()->route('admin.jobs.index')->with(['success' => 'Job updated successfully!']);
    }

    public function destroy($id)
    {
        $job = JobPost::findOrFail($id);
        $job->delete();

        return redirect()->back()->with(['success' => 'Job deleted successfully.']);
    }
}
