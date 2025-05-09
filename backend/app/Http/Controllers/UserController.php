<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'LIKE', "%$search%")
                  ->orWhere('email', 'LIKE', "%$search%");
        }

        return response()->json($query->get(), 200);
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6',
        'role' => 'required|string'
    ]);

    $validated['password'] = bcrypt($validated['password']);

    $user = User::create($validated);

    return response()->json(['message' => 'User added successfully!', 'user' => $user]);
}


public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,'.$id,
        'role' => 'required|string'
    ]);

    $user = User::findOrFail($id);
    $user->update($validated);

    return response()->json(['message' => 'User updated successfully!', 'user' => $user]);
}

    public function delete($id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['message' => 'User not found'], 404);

        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
