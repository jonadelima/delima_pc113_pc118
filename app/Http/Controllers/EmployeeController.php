<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    public function index(Request $request)
    {
        $query = Employee::query();
        
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
            'email' => 'required|email|unique:employees,email',
            'position' => 'required|string|max:255',
        
        ]);
        $employee = Employee::create($validatedData);
        return response()->json([
            'message' => 'Employee created successfully',
            'employee' => $employee], 201);
    }
    
        public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        if (is_null($employee)) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,'.$id,
            'position' => 'required|string|max:255',
        ]);

        $employee->update($validatedData);
        return response()->json([
            'message' => 'Employee updated successfully',
            'employee' => $employee,]);
    }

    public function delete($id)
    {
        $employee = Employee::find($id);
        if (is_null($employee)) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
        $employee->delete();
        return response()->json(['message' => 'Employee deleted successfully'],);
    }




}
 