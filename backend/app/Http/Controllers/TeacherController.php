<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(){
        $teacher = Auth::user();
        return response()->json([
            'message' => 'Welcome to the Teacher Dashboard',
            'teacher' => $teacher
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
}
