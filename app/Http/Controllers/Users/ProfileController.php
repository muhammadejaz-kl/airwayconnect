<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use App\Models\Subscription;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $subscription = null;

        if ($user->premiun_status == 1 && $user->plan_id) {
            $subscription = Subscription::find($user->plan_id);
        }

        return view('user.profile.index', compact('user', 'subscription'));
    }

    public function checkPassword(Request $request)
    {
        $request->validate(['current_password' => 'required']);

        if (Hash::check($request->current_password, Auth::user()->password)) {
            return response()->json(['valid' => true]);
        }

        return response()->json(['valid' => false]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($request->filled('current_password') && $request->filled('password')) {
            $request->validate([
                'current_password' => 'required',
                'password' => [
                    'required',
                    'confirmed',
                    Password::min(8)->letters()->mixedCase()->numbers()->symbols()
                ]
            ]);

            $user->update([
                'password' => Hash::make($request->password)
            ]);

            Auth::logout();

            return redirect()->route('login')->with(['success' => 'Password updated successfully. Please login again.']);
        }

        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'phone_code' => 'nullable|string|max:5',
            'phone_number' => 'nullable|string|max:15',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:204899',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:409699',
        ]);

        $updateData = [];

        if ($request->filled('name') && $request->name !== $user->name) {
            $updateData['name'] = $request->name;
        }
        if ($request->filled('email') && $request->email !== $user->email) {
            $updateData['email'] = $request->email;
        }
        if ($request->filled('phone_code') && $request->phone_code !== $user->phone_code) {
            $updateData['phone_code'] = $request->phone_code;
        }
        if ($request->filled('phone_number') && $request->phone_number !== $user->phone_number) {
            $updateData['phone_number'] = $request->phone_number;
        }

        if ($request->hasFile('profile_image')) {
            $profilePath = $request->file('profile_image')->store('profiles', 'public');
            $updateData['profile_image'] = $profilePath;
        }

        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('covers', 'public');
            $updateData['cover_image'] = $coverPath;
        }

        if (!empty($updateData)) {
            $user->update($updateData);
        }

        return back()->with(['success' => 'Profile updated successfully.']);
    }
}
