<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AirlineDetailsDataTable;
use App\DataTables\AirlineDirectoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\AirlineDetail;
use App\Models\AirlineDirectory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AirlinesDirectoryController extends Controller
{

    public function index(AirlineDirectoryDataTable $dataTable)
    {
        return $dataTable->render('admin.airlinesDirectory.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $airline = new AirlineDirectory();
        $airline->name = $request->name;

        if ($request->hasFile('logo')) {
            $airline->logo = $request->file('logo')->store('logo', 'public');
        }

        $airline->save();

        return redirect()->back()->with('success', 'Airline added successfully.');
    }

    public function update(Request $request, $id)
    {
        $airline = AirlineDirectory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $airline->name = $request->name;

        if ($request->hasFile('logo')) {
            if ($airline->logo && Storage::disk('public')->exists($airline->logo)) {
                Storage::disk('public')->delete($airline->logo);
            }
            $airline->logo = $request->file('logo')->store('logo', 'public');
        }

        $airline->save();

        return redirect()->back()->with('success', 'Airline updated successfully.');
    }

    public function destroy($id)
    {
        $airline = AirlineDirectory::findOrFail($id);
        $airline->delete();

        return redirect()->back()->with('success', 'Airline deleted successfully.');
    }

    public function show(AirlineDetailsDataTable $dataTable, $id)
    { 
        $airline = AirlineDirectory::with('details')->findOrFail($id);

        return $dataTable->render('admin.airlinesDirectory.show', compact('airline'));
    }

    public function storeDetails(Request $request)
    {
        $request->validate([
            'airline_id'      => 'required|exists:airline_directories,id',
            'part'            => 'required|string|max:255',
            'airlines_type'   => 'required|string',
            'job_type'        => 'required|in:PartTime,FullTime,Remote',
            'schedule_type'   => 'required|string',
            'option_401k'     => 'required|in:Yes,No',
            'flight_benefits' => 'required|in:Yes,No',
            'description'     => 'nullable|string',
        ]);

        $airline = AirlineDirectory::findOrFail($request->airline_id);

        $airline->details()->create($request->only([
            'part',
            'airlines_type',
            'job_type',
            'schedule_type',
            'option_401k',
            'flight_benefits',
            'description',
        ]));

        return redirect()->route('admin.airlinesDirectory.show', $airline->id)->with('success', 'Airline details added successfully.');
    }

    public function updateDetails(Request $request, $id)
    {
        $detail = AirlineDetail::findOrFail($id);

        $request->validate([
            'part'            => 'required|string|max:255',
            'airlines_type'   => 'required|string',
            'job_type'        => 'required|in:PartTime,FullTime,Remote',
            'schedule_type'   => 'required|string',
            'option_401k'     => 'required|in:Yes,No',
            'flight_benefits' => 'required|in:Yes,No',
            'description'     => 'nullable|string',
        ]);

        $detail->update($request->only([
            'part',
            'airlines_type',
            'job_type',
            'schedule_type',
            'option_401k',
            'flight_benefits',
            'description',
        ]));

        return redirect()->route('admin.airlinesDirectory.show', $detail->airline_id)->with('success', 'Airline details updated successfully.');
    }

    public function destroyDetails($id)
    {
        $detail = AirlineDetail::findOrFail($id);
        $detail->delete();

        return redirect()->back()->with('success', 'Airline Details deleted successfully.');
    }
}
