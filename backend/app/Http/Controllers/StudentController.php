<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\StudentImport;
use App\Exports\StudentExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Student;
use Exception;

class StudentController extends Controller
{
    public function getStudents()
    {
        $students = Student::all();
        return response()->json($students);
    }

    public function importStudents(Request $request)
    {
        try{
            $request->validate([
                'file' => 'required|mimes:xlsx,csv,xls'
            ]);
            $import = new StudentImport;
            Excel::import($import, $request->file('file'));

            foreach ($import->rows as $row) {
                Student::create([
                    'student_id' => $row['student_id'],
                    'name'       => $row['name'],
                    'course'     => $row['course'],
                    'status'     => $row['status'] ?? 'active', // Default to 'active' if not provided
                ]);
            }
    
            return response()->json(['message' => 'Students imported successfully']);
        }catch (Exception $e) {
            return response()->json(['error' => 'Failed to import students: ' . $e->getMessage()], 500);
        }
    }

    public function exportStudents()
    {
        return Excel::download(new StudentExport, 'students.xlsx');
    }
}
