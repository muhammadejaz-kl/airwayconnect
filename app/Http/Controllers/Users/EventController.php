<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function show()
    {
        $events = Event::where('date', '>', Carbon::today())->latest()->take(3)->get();

        return view('user.event.index', compact('events'));
    }


    public function showdetails($id)
    {
        $event = Event::findOrFail($id); // Get event by ID or throw 404
        return view('user.event.show', compact('event'));
    }
}
