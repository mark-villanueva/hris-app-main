<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('positions')->insert([
            [
                'position' => 'HR Manager',
                'status' => 'Active',
                'description' => 'Responsible for overseeing the HR department.',
                'departments_id' => 1, // Assuming 'Human Resources' department id is 1
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'position' => 'Finance Analyst',
                'status' => 'Active',
                'description' => 'Analyzes financial data and trends.',
                'departments_id' => 2, // Assuming 'Finance' department id is 2
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'position' => 'IT Support Specialist',
                'status' => 'Active',
                'description' => 'Provides IT support and maintenance.',
                'departments_id' => 3, // Assuming 'IT' department id is 3
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'position' => 'Marketing Coordinator',
                'status' => 'Active',
                'description' => 'Coordinates marketing activities.',
                'departments_id' => 4, // Assuming 'Marketing' department id is 4
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
