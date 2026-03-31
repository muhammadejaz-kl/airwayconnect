<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TestimoniesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Testimony;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class TestimonyController extends Controller
{
    public function index(TestimoniesDataTable $dataTable)
    {
        return $dataTable->render('admin.testimonies.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'role'        => 'required|string|max:255',
            'rating'      => 'required|numeric|min:1|max:5',
            'description' => 'required|string',
            'profile_image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name'        => $validated['name'],
            'role'        => $validated['role'],
            'rating'      => $validated['rating'],
            'description' => $validated['description'],
        ];

        if ($request->hasFile('profile_image')) {
            $profilePath = $request->file('profile_image')->store('testimonials', 'public');
            $data['profile_image'] = $profilePath;
        }

        Testimony::create($data);

        return redirect()->back()->with('success', 'Testimonial added successfully.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'role'        => 'required|string|max:255',
            'rating'      => 'required|numeric|min:1|max:5',
            'description' => 'required|string',
            'status'      => 'required|in:0,1',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $testimony = Testimony::findOrFail($id);

        $data = [
            'name'        => $validated['name'],
            'role'        => $validated['role'],
            'rating'      => $validated['rating'],
            'description' => $validated['description'],
            'status'      => $validated['status'],
        ];

        if ($request->hasFile('profile_image')) {
            if ($testimony->profile_image && \Storage::disk('public')->exists($testimony->profile_image)) {
                \Storage::disk('public')->delete($testimony->profile_image);
            }

            $profilePath = $request->file('profile_image')->store('testimonials', 'public');
            $data['profile_image'] = $profilePath;
        }

        $testimony->update($data);

        return redirect()->back()->with('success', 'Testimonial updated successfully.');
    }

    public function destroy($id)
    {
        $testimony = Testimony::findOrFail($id);
        $testimony->delete();

        return redirect()->back()->with('success', 'Testimony deleted successfully!');
    }
}
