<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Exception;

class AuthController extends Controller
{
 public function register(Request $request){
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
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ], 201);
    }




  public function login(Request $request){
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
    }

       public function logout(Request $request)
        {
            $user = Auth::user();
            $user->tokens()->delete();
        
            return response()->json([
                'message' => 'Logout successful',
            ]);
        }
}
         