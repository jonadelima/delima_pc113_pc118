<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index(Request $request)
{
    return response()->json(Submission::with('student', 'task')->get()->map(function ($submission) {
        return [
            'student_name' => $submission->student->name,
            'task_title' => $submission->task->title,
            'file_url' => asset('storage/' . $submission->file_path),
            'submitted_at' => $submission->created_at,
            'status' => $submission->status,
        ];
    }));
}

}
