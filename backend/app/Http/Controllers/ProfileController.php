<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // GET /api/profile
    public function show()
    {
        return response()->json(Auth::user());
    }

    // PUT /api/profile/update
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id, // allow current user's email
        ]);

        // Update user details
        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $user
        ]);
    }
}
