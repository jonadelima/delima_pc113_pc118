<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Exception;
use App\Mail\ThankYouForRegistering;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
{
    try {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => bcrypt($validate['password']),
            'role' => 1,
        ]);

        // Send Thank You Email
        Mail::to($user->email)->send(new ThankYouForRegistering($user));

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ], 201);

    } catch (ValidationException $e) {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $e->errors(),
        ], 422);
    } catch (Exception $e) {
        return response()->json([
            'message' => 'An error occurred during registration',
            'error' => $e->getMessage(),
        ], 500);
    }
}

    public function login(Request $request)
    {
        try {
            if (Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
            ])) {
                $user = Auth::user();
                $token = $user->createToken('mytoken')->plainTextToken;

                return response()->json([
                    'message' => 'Login successful',
                    'token' => $token,
                    'role' => $user->role,
                ]);
            } else {
                return response()->json([
                    'message' => 'Invalid credentials',
                ], 401);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred during login',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = Auth::user();
            $user->tokens()->delete();

            return response()->json([
                'message' => 'Logout successful',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred during logout',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
