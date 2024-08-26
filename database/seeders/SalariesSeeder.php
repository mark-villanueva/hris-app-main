<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalariesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('salaries')->insert([
            [
                'name' => 'HR Manager',
                'description' => 'Salary package for HR Manager.',
                'daily_rate' => 2500.00,
                'hourly_rate' => 312.50,
                'bir' => 250.00,
                'sss' => 125.00,
                'philhealth' => 93.75,
                'pagibig' => 50.00,
                'ot_rate' => 375.00,
                'nta' => 500.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Finance Analyst',
                'description' => 'Salary package for Finance Analyst.',
                'daily_rate' => 1000.00,
                'hourly_rate' => 125.00,
                'bir' => 100.00,
                'sss' => 50.00,
                'philhealth' => 37.50,
                'pagibig' => 20.00,
                'ot_rate' => 150.00,
                'nta' => 200.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'IT Support Specialist',
                'description' => 'Salary package for IT Support Specialist.',
                'daily_rate' => 2000.00,
                'hourly_rate' => 250.00,
                'bir' => 200.00,
                'sss' => 100.00,
                'philhealth' => 75.00,
                'pagibig' => 40.00,
                'ot_rate' => 300.00,
                'nta' => 400.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Marketing Coordinator',
                'description' => 'Salary package for Marketing Coordinator.',
                'daily_rate' => 3000.00,
                'hourly_rate' => 375.00,
                'bir' => 300.00,
                'sss' => 150.00,
                'philhealth' => 112.50,
                'pagibig' => 60.00,
                'ot_rate' => 450.00,
                'nta' => 600.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more salary records as needed
        ]);
    }
}
