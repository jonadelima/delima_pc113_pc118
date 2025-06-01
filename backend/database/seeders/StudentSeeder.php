<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run()
    {
        Student::insert([
            ['student_id' => 'STU001', 'name' => 'Juan Dela Cruz', 'course' => 'BSIT', 'status' => 'Active'],
            ['student_id' => 'STU002', 'name' => 'Maria Clara', 'course' => 'BSBA', 'status' => 'Active'],
            ['student_id' => 'STU003', 'name' => 'Pedro Penduko', 'course' => 'BSIT', 'status' => 'Inactive'],
            ['student_id' => 'STU004', 'name' => 'Andres Bonifacio', 'course' => 'BSED', 'status' => 'Active'],
            ['student_id' => 'STU005', 'name' => 'Jose Rizal', 'course' => 'BSA', 'status' => 'Active'],
            ['student_id' => 'STU006', 'name' => 'Emilio Aguinaldo', 'course' => 'BSIT', 'status' => 'Inactive'],
            ['student_id' => 'STU007', 'name' => 'Gregoria de Jesus', 'course' => 'BSED', 'status' => 'Active'],
            ['student_id' => 'STU008', 'name' => 'Apolinario Mabini', 'course' => 'BSCS', 'status' => 'Active'],
            ['student_id' => 'STU009', 'name' => 'Melchora Aquino', 'course' => 'BSBA', 'status' => 'Inactive'],
            ['student_id' => 'STU010', 'name' => 'Antonio Luna', 'course' => 'BSN', 'status' => 'Active'],
        ]);
    }
}
