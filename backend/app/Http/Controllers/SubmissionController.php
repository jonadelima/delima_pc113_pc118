<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class SubmissionController extends Controller
{
    // Export dummy student list
    public function export()
    {
        $data = [
            ['Student ID', 'Name', 'Course'],
            ['STU001', 'Juan Dela Cruz', 'BSIT'],
            ['STU002', 'Maria Santos', 'BSCS'],
            ['STU003', 'Pedro Reyes', 'BSIT']
            
        ];

        $filename = 'students_export.csv';
        $handle = fopen(storage_path("app/{$filename}"), 'w');

        foreach ($data as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        return response()->download(storage_path("app/{$filename}"));
    }

    // Import student list from uploaded CSV
    public function import(Request $request)
    {
        if (!$request->hasFile('csv_file')) {
            return response()->json(['error' => 'No file uploaded.'], 400);
        }

        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file));
        
        // Remove header
        array_shift($data);

        return response()->json([
            'message' => 'Imported successfully',
            'students' => $data
        ]);
    }
}
