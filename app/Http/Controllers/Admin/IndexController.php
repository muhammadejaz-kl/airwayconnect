<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Forum;
use App\Models\JobPost;
use App\Models\User;
use Carbon\Carbon;
use App\DataTables\UsersDataTable;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function dashboard(UsersDataTable $dataTable)
    {
        $today = Carbon::today();

        // Users
        $users = User::role('user')->get();
        $totalUsers = $users->count();
        $activeUsers = $users->where('status', 1)->count();
        $inactiveUsers = $users->where('status', 0)->count();
        $subscribers = $users->where('premiun_status', 1)->count();

        // Forum Posts
        $forums = Forum::all();
        $totalForums = $forums->count();
        $activeForums = $forums->where('status', 1)->count();
        $inactiveForums = $forums->where('status', 0)->count();

        //events
        $events = Event::all();
        $totalevents = $events->count();
        $todayEvents = $events->where('date', $today->toDateString())->count();
        $upcomingEvents = $events->where('date', '>', $today->toDateString())->count();
        $pastEvents = $events->where('date', '<', $today->toDateString())->count();

        //jobs
        $jobs = JobPost::all();
        $totaljobs = $jobs->count();
        $activejobs = $jobs->where('status', 1)->count();
        $inactivejobs = $jobs->where('status', 0)->count();

        return $dataTable->render('admin.index', compact(
            'totalUsers',
            'activeUsers',
            'inactiveUsers',
            'totalForums',
            'activeForums',
            'inactiveForums',
            'totaljobs',
            'activejobs',
            'inactivejobs',
            'totalevents',
            'todayEvents',
            'upcomingEvents',
            'pastEvents',
            'subscribers'
        ));
    }

    public function profile()
    {
        return view('admin.profile.profile');
    }
}
