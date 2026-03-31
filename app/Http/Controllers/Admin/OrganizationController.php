<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\OrganizationsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Models\Organization;
use Illuminate\Http\Request;
use function Termwind\render;

class OrganizationController extends Controller
{
    public function index(OrganizationsDataTable $dataTable)
    {
        return $dataTable->render('admin.organizations.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'sector' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'purpose' => 'nullable|string|max:255',
            'established' => 'nullable|date',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('organizations', 'public');
        }

        $organization = Organization::create([
            'name' => $request->name,
            'type' => $request->type,
            'sector' => $request->sector,
            'link' => $request->link,
            'purpose' => $request->purpose,
            'established' => $request->established,
            'description' => $request->description,
            'logo' => $logoPath,
        ]);

        $message = "🌐 New Organization Added: '{$organization->name}' has been added to the directory. Check it out!";
        app(NotificationController::class)->send($message, 'organization');

        return redirect()->back()->with('success', 'Organization added successfully and notification sent!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'sector' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'purpose' => 'nullable|string|max:255',
            'established' => 'nullable|date',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $organization = Organization::findOrFail($id);
        $organization->name = $request->name;
        $organization->type = $request->type;
        $organization->sector = $request->sector;
        $organization->link = $request->link;
        $organization->purpose = $request->purpose;
        $organization->established = $request->established;
        $organization->description = $request->description;

        if ($request->hasFile('logo')) {
            $organization->logo = $request->file('logo')->store('organizations', 'public');
        }

        $organization->save();

        return redirect()->back()->with('success', 'Organization updated successfully.');
    }

    public function destroy($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->delete();

        return redirect()->back()->with('success', 'Airline organization deleted successfully.');
    }

}
