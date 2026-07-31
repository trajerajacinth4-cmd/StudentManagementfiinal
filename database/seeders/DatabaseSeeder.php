<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
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
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
            ]
        );

        Student::updateOrCreate(
            ['email' => 'john.doe@example.com'],
            [
                'name' => 'John Doe',
                'course' => 'Computer Science',
                'age' => 20,
            ]
        );

        Student::updateOrCreate(
            ['email' => 'jane.smith@example.com'],
            [
                'name' => 'Jane Smith',
                'course' => 'Information Technology',
                'age' => 22,
            ]
        );

        Student::updateOrCreate(
            ['email' => 'alex.johnson@example.com'],
            [
                'name' => 'Alex Johnson',
                'course' => 'Software Engineering',
                'age' => 21,
            ]
        );
    }
}
