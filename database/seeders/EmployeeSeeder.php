<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        Employee::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'position' => 'Manager'
        ]);
    }
}
