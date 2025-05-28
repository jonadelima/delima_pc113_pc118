<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AssistantTeacherController extends Controller
{
    public function index(){
        $assistantteacher = Auth::user();
        return response()->json([
            'message' => 'Welcome to the Assistant Teacher Dashboard',
            'assistant_teacher' => $assistantteacher
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
