<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin Account
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
            ]
        );

        // Seed Courses
        $courses = [
            ['code' => 'BSCS', 'name' => 'Bachelor of Science in Computer Science', 'description' => 'Software development, algorithms, and computing fundamentals.'],
            ['code' => 'BSIT', 'name' => 'Bachelor of Science in Information Technology', 'description' => 'Network systems, web technologies, and IT management.'],
            ['code' => 'BSSE', 'name' => 'Bachelor of Science in Software Engineering', 'description' => 'Large scale software architecture, DevOps, and quality assurance.'],
            ['code' => 'BSCY', 'name' => 'Bachelor of Science in Cyber Security', 'description' => 'Information security, ethical hacking, and network defense.'],
        ];

        foreach ($courses as $c) {
            Course::updateOrCreate(['code' => $c['code']], $c);
        }

        // Seed Sample Students with Separated Names
        Student::updateOrCreate(
            ['email' => 'john.doe@example.com'],
            [
                'student_number' => 'STD-2026-00001',
                'first_name'     => 'John',
                'middle_name'    => 'Mark',
                'last_name'      => 'Doe',
                'course'         => 'BSCS',
                'year_level'     => '1st Year',
                'status'         => 'Active',
                'gpa'            => 3.85,
                'age'            => 20,
            ]
        );

        Student::updateOrCreate(
            ['email' => 'jane.smith@example.com'],
            [
                'student_number' => 'STD-2026-00002',
                'first_name'     => 'Jane',
                'middle_name'    => 'Marie',
                'last_name'      => 'Smith',
                'course'         => 'BSIT',
                'year_level'     => '2nd Year',
                'status'         => 'Active',
                'gpa'            => 3.92,
                'age'            => 22,
            ]
        );

        Student::updateOrCreate(
            ['email' => 'alex.johnson@example.com'],
            [
                'student_number' => 'STD-2026-00003',
                'first_name'     => 'Alex',
                'middle_name'    => '',
                'last_name'      => 'Johnson',
                'course'         => 'BSSE',
                'year_level'     => '3rd Year',
                'status'         => 'Active',
                'gpa'            => 3.65,
                'age'            => 21,
            ]
        );

        Student::updateOrCreate(
            ['email' => 'sarah.connor@example.com'],
            [
                'student_number' => 'STD-2026-00004',
                'first_name'     => 'Sarah',
                'middle_name'    => 'Jane',
                'last_name'      => 'Connor',
                'course'         => 'BSCY',
                'year_level'     => '4th Year',
                'status'         => 'Active',
                'gpa'            => 4.00,
                'age'            => 23,
            ]
        );
    }
}
