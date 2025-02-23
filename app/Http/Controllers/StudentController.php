<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'LIKE', "%$search%")
            ->orWhere('email', 'LIKE', "%$search%"); 
        }

        return response()->json($query->get(), 200);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
           'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students',
            'course' => 'required|string|max:255',
        
        ]);
        $student = Student::create($validatedData);
        return response()->json([
            'message' => 'Student created successfully',
            'employee' => $student], 201);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        if (is_null($student)) {
            return response()->json(['message' => 'Student not found'], 404);
        }
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:students,email,' . $id,
            'course' => 'sometimes|string|max:255',
        ]);

        $student->update($validatedData);
        return response()->json([
            'message' => 'Employee updated successfully',
            'employee' => $student]);
    }

    public function delete($id)
    {
        $student = Student::find($id);
        if (is_null($student)) {
            return response()->json(['message' => 'Student not found'], 404);
        }
        $student->delete();
        return response()->json(['message' => 'student deleted successfully'],);
    }








    

    
    
}
