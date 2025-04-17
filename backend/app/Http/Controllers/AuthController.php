<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Exception;

class AuthController extends Controller
{
    public function index()
    {
        try {
            return response()->json(User::all(), 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Something went wrong!',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }
    // public function login(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'email' => 'required|email',
    //             'password' => 'required|string',
    //         ]);

    //         $user = User::where('email', $request->email)->first();

    //         if (!$user || !Hash::check($request->password, $user->password)) {
    //             return response()->json([
    //                 'error' => 'Invalid email or password.'
    //             ], 401);
    //         }

    //         // Generate Token
    //         $token = $user->createToken('auth_token')->plainTextToken;

    //         return response()->json([
    //             'message' => 'Login successful',
    //             'user' => [
    //                 'id' => $user->id,
    //                 'name' => $user->name,
    //                 'email' => $user->email,
    //                 'role' => $user->role, // 👈 add this line
    //             ],
    //             'token' => $token
    //         ], 200);
            
    //     } catch (ValidationException $e) {
    //         return response()->json([
    //             'error' => 'Validation error',
    //             'messages' => $e->errors()
    //         ], 422);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'error' => 'Something went wrong!',
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }
}
