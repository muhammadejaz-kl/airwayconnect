<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Legal;
use Illuminate\Http\Request;

class LegalsController extends Controller
{
    public function index()
    {
        $legalEntries = Legal::whereIn('key', ['terms', 'privacy', 'cookie'])->pluck('value', 'key')->toArray();
        return view('admin.legals.index', compact('legalEntries'));
    }

    public function store(Request $request)
    {
        $type = $request->input('tab_type');

        switch ($type) {
            case 'legal_terms':
                Legal::updateOrCreate(
                    ['key' => 'terms'],
                    ['value' => $request->input('legal_terms'), 'type' => 'string']
                );
                break;

            case 'legal_privacy':
                Legal::updateOrCreate(
                    ['key' => 'privacy'],
                    ['value' => $request->input('legal_privacy'), 'type' => 'string']
                );
                break;

            case 'legal_cookie':
                Legal::updateOrCreate(
                    ['key' => 'cookie'],
                    ['value' => $request->input('legal_cookie'), 'type' => 'string']
                );
                break;
        }

        return redirect()->back()->with('success', 'Legal content updated successfully.');
    }
}

