<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\AirlineDirectory;
use Illuminate\Http\Request;

class AirlineDirectoryController extends Controller
{
    public function index(Request $request)
    { 
        $selectedLetter = strtoupper($request->query('letter', 'A'));
 
        $airlines = AirlineDirectory::orderBy('name', 'asc')->get();
 
        return view('user.airlinesDirectory.index', compact('airlines', 'selectedLetter'));
    }

    public function show($id)
    {
        $airline = AirlineDirectory::with('details')->findOrFail($id);

        return view('user.airlinesDirectory.show', compact('airline'));
    }
}
