<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            [
                'department' => 'Human Resources',
                'manager' => 'Alice Johnson',
                'description' => 'Handles employee relations and benefits.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department' => 'Finance',
                'manager' => 'Bob Smith',
                'description' => 'Manages company finances and budgets.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department' => 'IT',
                'manager' => 'Carol Williams',
                'description' => 'Responsible for technology and IT support.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department' => 'Marketing',
                'manager' => 'David Brown',
                'description' => 'Oversees marketing and advertising efforts.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
