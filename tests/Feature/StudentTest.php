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
            'age' => 20,
        ]);

        $response = $this->actingAs($user)->get('/students');
        $response->assertStatus(200);
        $response->assertSee('John Student');
    }

    public function test_authenticated_user_can_create_student()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/students', [
            'name' => 'Alice Green',
            'email' => 'alice@example.com',
            'course' => 'Mathematics',
            'age' => 19,
        ]);

        $response->assertRedirect('/students');
        $this->assertDatabaseHas('students', [
            'email' => 'alice@example.com',
        ]);
    }

    public function test_authenticated_user_can_download_pdf()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/students/download-pdf');
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }
}
