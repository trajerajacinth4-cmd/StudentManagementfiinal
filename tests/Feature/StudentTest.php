<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_students()
    {
        $response = $this->get('/students');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_student_list()
    {
        $user = User::factory()->create();
        Student::create([
            'name' => 'John Student',
            'email' => 'john@student.com',
            'course' => 'Physics',
            'year_level' => '1st Year',
            'age' => 20,
        ]);

        $response = $this->actingAs($user)->get('/students');
        $response->assertStatus(200);
        $response->assertSee('John Student');
        $response->assertSee('1st Year');
    }

    public function test_authenticated_user_can_filter_students_by_year_level()
    {
        $user = User::factory()->create();

        Student::create([
            'name' => 'First Year Student',
            'email' => 'first@example.com',
            'course' => 'CS',
            'year_level' => '1st Year',
            'age' => 18,
        ]);

        Student::create([
            'name' => 'Third Year Student',
            'email' => 'third@example.com',
            'course' => 'IT',
            'year_level' => '3rd Year',
            'age' => 21,
        ]);

        $response = $this->actingAs($user)->get('/students?year_level=3rd+Year');
        $response->assertStatus(200);
        $response->assertSee('Third Year Student');
        $response->assertDontSee('First Year Student');
    }

    public function test_authenticated_user_can_create_student_with_year_level()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/students', [
            'first_name' => 'Alice',
            'last_name' => 'Green',
            'name' => 'Alice Green',
            'email' => 'alice@example.com',
            'course' => 'Mathematics',
            'year_level' => '2nd Year',
            'status' => 'Active',
            'age' => 19,
        ]);

        $response->assertRedirect('/students');
        $this->assertDatabaseHas('students', [
            'email' => 'alice@example.com',
            'year_level' => '2nd Year',
        ]);
    }

    public function test_authenticated_user_can_download_pdf_with_filter()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/students/download-pdf?year_level=1st+Year');
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }
}
