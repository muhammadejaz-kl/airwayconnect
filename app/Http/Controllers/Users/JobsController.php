<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPost::where('status', 1)
            ->where('last_date', '>', Carbon::today());

        if ($request->filled('airlines')) {
            $query->where('for_airlines', 'like', '%' . $request->airlines . '%');
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('experience')) {
            $query->where('experience', 'like', '%' . $request->experience . '%');
        }

        $jobs = $query->latest()->paginate(5)->appends($request->query());

        return view('user.job.index', compact('jobs'));
    }
}
