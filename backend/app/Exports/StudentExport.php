<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Student::select('student_id', 'name', 'course', 'status')->get();
    }

    public function headings(): array
    {
        return ['Student ID', 'Name', 'Course', 'Status'];
    }
}
