<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json([
            'users' => $users
        ]);
    }


     public function store(Request $request){
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|integer|in:0,1,2', // 0: admin, 1: Teacher, 2: Assistant Teacher
        ]);
        $user = User::create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => bcrypt($validate['password']),
            'role' => $validate['role'],
        ]);
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ], 201);
    }

     public function update(Request $request, $id){
            $user = User::find($id);
             $request->validate([
                'name' => 'string|max:255',
                'email' => 'string|email|max:255',
                'password' => 'string|min:8',
                'role' => 'integer|in:0,1,2', // 0: admin, 1: Teacher, 2: Assistant Teacher
             ]);

             $user->update($request->all());
             return response()->json([
                'message' => 'User updated successfully',
                'user' => $user,
             ]);
        }

     public function logout(Request $request)
        {
            $user = Auth::user();
            $user->tokens()->delete();
        
            return response()->json([
                'message' => 'Logout successful',
            ]);
        }


        public function destroy($id)
        {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'message' => 'User not found',
                ], 200);
            }
            return response()->json([
                'deleted' => $user->delete(),
                'message' => 'User deleted successfully',
            ], 404);
        }

           public function profile(){
          
            $user = auth()->user();
            return response()->json([
                'name' => $user->name,
                'email' => $user->email, 
                'role' => $user->role,
            ]);
        }
}
        