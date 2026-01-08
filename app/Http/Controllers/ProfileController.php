<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('detail');
        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'username' => 'required|string|alpha_dash|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'full_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
        ]);

        $detailData = [
            'full_name' => $request->full_name,
            'phone_number' => $request->phone_number,
        ];

        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($user->detail->avatar) {
                Storage::delete('public/' . $user->detail->avatar);
            }
            $detailData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->detail()->update($detailData);

        return back()->with('success', 'Profile updated successfully.');
    }
}
