<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        User::factory()->create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
        ]);

        User::factory()->create([
            'name' => 'Robert Williams',
            'email' => 'robert.williams@example.com',
        ]);

        User::factory()->create([
            'name' => 'Emily Brown',
            'email' => 'emily.brown@example.com',
        ]);

        User::factory()->create([
            'name' => 'Michael Johnson',
            'email' => 'michael.johnson@example.com',
        ]);

        $this->call(DepartmentsSeeder::class);
        $this->call(PositionsSeeder::class);
        $this->call(SalariesSeeder::class);
        $this->call(EmployeesSeeder::class);
    }
}
