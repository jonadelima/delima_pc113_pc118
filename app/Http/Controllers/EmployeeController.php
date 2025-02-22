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
}
