<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class StudentController extends Controller
{
    // Get all students
    public function index()
    {
        return response()->json(Student::all());
    }

    // Import CSV
    public function import(Request $request)
    {
        $file = $request->file('file');
        if (!$file->isValid()) return response()->json(['error' => 'Invalid file'], 400);

        $handle = fopen($file, 'r');
        $header = fgetcsv($handle);

        while (($data = fgetcsv($handle)) !== false) {
            Student::create([
    'student_id' => $data[0],
    'name'       => $data[1],
    'course'     => $data[2],
    'status'     => $data[3] ?? 'Not Submitted',
]);

        }

        return response()->json(['message' => 'Import successful']);
    }

    // Export CSV
    public function export()
    {
        $students = Student::all();
        $csv = "Student ID,Name,Course,Status\n";

        foreach ($students as $student) {
    $csv .= "{$student->student_id},{$student->name},{$student->course},{$student->status}\n";
}

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="students.csv"');
    }
}
