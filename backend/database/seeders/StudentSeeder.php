<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run()
    {
        Student::create([
            'name' => 'Alice Smith',
            'email' => 'alice@example.com',
            'course' => 'Computer Science'
        ]);
    }
}
