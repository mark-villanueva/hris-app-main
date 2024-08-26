<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
            [
                'last_name' => 'Admin',
                'first_name' => 'Admin',
                'middle_name' => 'Admin',
                'gender' => 'Male',
                'birth_date' => '1980-01-01',
                'civil_status' => 'Single',
                'mobile_number' => '09171234567',
                'email' => 'admin@example.com',
                'address' => '123 Main St, Cityville',
                'tin' => '123-456-789',
                'sss' => '123-45-6789',
                'philhealth' => '123456789012',
                'pagibig' => '1234-5678-9101',
                'contact_name' => 'Jane Doe',
                'contact_number' => '09181234567',
                'relationship' => 'Sister',
                'departments_id' => 1, // Assuming 'Human Resources' department id is 1
                'user_id' => 1,
                'positions_id' => 1, // Assuming 'HR Manager' position id is 1
                'description' => 'Handles HR related tasks.',
                'salary_id' => 1, // Assuming this salary id exists
                'status' => 'Active',
                'start_date' => '2020-01-01',
                'end_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'last_name' => 'Smith',
                'first_name' => 'Jane',
                'middle_name' => 'Belson',
                'gender' => 'Female',
                'birth_date' => '1985-05-15',
                'civil_status' => 'Married',
                'mobile_number' => '09172345678',
                'email' => 'jane.smith@example.com',
                'address' => '456 Elm St, Townsville',
                'tin' => '234-567-890',
                'sss' => '234-56-7890',
                'philhealth' => '234567890123',
                'pagibig' => '2345-6789-0123',
                'contact_name' => 'John Smith',
                'contact_number' => '09183345678',
                'relationship' => 'Husband',
                'departments_id' => 2, // Assuming 'Finance' department id is 2
                'user_id' => 2,
                'positions_id' => 2, // Assuming 'Finance Analyst' position id is 2
                'description' => 'Analyzes financial data and trends.',
                'salary_id' => 2, // Assuming this salary id exists
                'status' => 'Active',
                'start_date' => '2019-03-01',
                'end_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'last_name' => 'Williams',
                'first_name' => 'Robert',
                'middle_name' => 'Carly',
                'gender' => 'Male',
                'birth_date' => '1990-08-20',
                'civil_status' => 'Single',
                'mobile_number' => '09173456789',
                'email' => 'robert.williams@example.com',
                'address' => '789 Pine St, Villagetown',
                'tin' => '345-678-901',
                'sss' => '345-67-8901',
                'philhealth' => '345678901234',
                'pagibig' => '3456-7890-1234',
                'contact_name' => 'Alice Williams',
                'contact_number' => '09184456789',
                'relationship' => 'Mother',
                'departments_id' => 3, // Assuming 'IT' department id is 3
                'user_id' => 3,
                'positions_id' => 3, // Assuming 'IT Support Specialist' position id is 3
                'description' => 'Provides IT support and maintenance.',
                'salary_id' => 3, // Assuming this salary id exists
                'status' => 'Active',
                'start_date' => '2018-07-15',
                'end_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'last_name' => 'Brown',
                'first_name' => 'Emily',
                'middle_name' => 'Durham',
                'gender' => 'Female',
                'birth_date' => '1995-11-30',
                'civil_status' => 'Single',
                'mobile_number' => '09174567890',
                'email' => 'emily.brown@example.com',
                'address' => '321 Oak St, Hamletville',
                'tin' => '456-789-012',
                'sss' => '456-78-9012',
                'philhealth' => '456789012345',
                'pagibig' => '4567-8901-2345',
                'contact_name' => 'George Brown',
                'contact_number' => '09185567890',
                'relationship' => 'Father',
                'departments_id' => 4, // Assuming 'Marketing' department id is 4
                'user_id' => 4,
                'positions_id' => 4, // Assuming 'Marketing Coordinator' position id is 4
                'description' => 'Coordinates marketing activities.',
                'salary_id' => 4, // Assuming this salary id exists
                'status' => 'Active',
                'start_date' => '2017-09-10',
                'end_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'last_name' => 'Johnson',
                'first_name' => 'Michael',
                'middle_name' => 'Ethyl',
                'gender' => 'Male',
                'birth_date' => '1988-12-22',
                'civil_status' => 'Married',
                'mobile_number' => '09175678901',
                'email' => 'michael.johnson@example.com',
                'address' => '654 Maple St, Township',
                'tin' => '567-890-123',
                'sss' => '567-89-0123',
                'philhealth' => '567890123456',
                'pagibig' => '5678-9012-3456',
                'contact_name' => 'Laura Johnson',
                'contact_number' => '09186678901',
                'relationship' => 'Wife',
                'departments_id' => 2, // Assuming 'Finance' department id is 2
                'user_id' => 5,
                'positions_id' => 2, // Assuming 'Finance Analyst' position id is 2
                'description' => 'Analyzes financial data and trends.',
                'salary_id' => 2, // Assuming this salary id exists
                'status' => 'Active',
                'start_date' => '2016-02-20',
                'end_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more employee records as needed
        ]);
    }
}
