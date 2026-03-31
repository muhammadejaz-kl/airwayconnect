<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SubscriptionPlansDataTable;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use function Termwind\render;

class SubscriptionController extends Controller
{
    public function index(SubscriptionPlansDataTable $dataTable)
    {
        return $dataTable->render("admin.subscriptions.index");
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'validity' => 'required|in:1_month,1_year',
            'amount' => 'required|numeric|min:0',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string|max:255',
        ]);

        $data = [
            'name' => $request->name,
            'validity' => $request->validity,
            'amount' => $request->amount,
            'features' => $request->features ? json_encode($request->features) : json_encode([]),
        ];

        $subscription = Subscription::create($data);

        return redirect()->back()->with('success', 'Subscription plan created successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'validity' => 'required|string',
            'amount' => 'required|numeric',
            'features' => 'nullable|array',
            'status' => 'required|boolean',
        ]);

        $subscription = Subscription::findOrFail($id);
        $subscription->update([
            'name' => $request->name,
            'validity' => $request->validity,
            'amount' => $request->amount,
            'features' => $request->features ? json_encode($request->features) : json_encode([]),
            'status' => $request->status,
        ]);

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription updated successfully.');
    }

    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();

        return redirect()->back()->with('success', 'Subscription deleted successfully!');
    }
}
