<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;

class OrgController extends Controller
{
    public function index()
    {
        $organizations = Organization::latest()->take(3)->get();
        return view('user.organizations.index', compact('organizations'));
    }

    public function show()
    {
        $organizations = Organization::latest()->get();
        return view('user.organizations.show', compact('organizations'));
    }

    public function details($id)
    {
        $organization = Organization::findOrFail($id);
        return view('user.organizations.details', compact('organization'));
    }
}
