<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\InterviewTopic;
use App\Models\JobPost;
use App\Models\Legal;
use App\Models\Organization;
use App\Models\Resource;
use App\Models\AirlineDirectory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        $jobs = JobPost::where('status', 1)->where('last_date', '>', Carbon::today())->latest()->take(5)->get();
        $topics = InterviewTopic::where('status', 1)->latest()->take(6)->get();
        $resources = Resource::latest()->take(2)->get();
        $organizations = Organization::latest()->take(2)->get();
        $events = Event::latest()->take(3)->get();
        $airlines = AirlineDirectory::inRandomOrder()->take(10)->get();
        return view('user.index', compact('jobs', 'topics', 'resources', 'events', 'airlines', 'organizations'));
    }

    public function termsServices()
    {
        $content = Legal::where('key', 'terms')->value('value');
        return view('legals', [
            'title' => 'Terms of Service',
            'content' => $content
        ]);
    }

    public function privacyPolicies()
    {
        $content = Legal::where('key', 'privacy')->value('value');
        return view('legals', [
            'title' => 'Privacy Policy',
            'content' => $content
        ]);
    }

    public function cookiesPolicies()
    {
        $content = Legal::where('key', 'cookie')->value('value');
        return view('legals', [
            'title' => 'Cookie Policy',
            'content' => $content
        ]);
    }
}
