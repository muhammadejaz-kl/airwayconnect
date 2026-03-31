<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Organization;
use App\Models\Resource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function index()
    {
        $organizations = Organization::latest()->take(3)->get();
        $resources = Resource::latest()->take(2)->get();
        $events = Event::where('date', '>', Carbon::today())->latest()->take(3)->get();
        return view('user.resource.index', compact('resources', 'events', 'organizations'));
    }

    public function show()
    {
        $resources = Resource::latest()->get();
        return view('user.resource.show', compact('resources'));
    }

    public function showdetails($id)
    {
        $resource = Resource::findOrFail($id);
        return view('user.resource.details', compact('resource'));
    }
}
