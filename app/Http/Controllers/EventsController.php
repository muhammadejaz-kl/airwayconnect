<?php

namespace App\Http\Controllers;

use App\DataTables\EventsDataTable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Controllers\NotificationController;

class EventsController extends Controller
{
    public function index(EventsDataTable $dataTable)
    {
        return $dataTable->render('admin.events.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'date' => 'nullable|date',
            'timing' => 'nullable|string',
            'about' => 'nullable|string',
            'banner' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('events', 'public');
        }

        $event = Event::create($validated);

        $eventDate = $event->date ? Carbon::parse($event->date)->format('d M Y') : 'TBD';
        $eventTime = $event->timing ?? 'TBD';
        $eventLocation = $event->location ?? 'Online/Not specified';

        $message = "⏰ Save the Date! '{$event->title}' at {$eventLocation} on {$eventDate} at {$eventTime}.";

        app(NotificationController::class)->send($message, 'event');

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully and notifications sent!');
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.show', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'date' => 'nullable|date',
            'timing' => 'nullable|string',
            'about' => 'nullable|string',
            'banner' => 'nullable|image|max:204899',
        ]);

        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('events', 'public');
        }

        $event->update($validated);
        return redirect()->back()->with('success', 'Event updated successfully!');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->back()->with('success', 'Event deleted successfully.');
    }
}
