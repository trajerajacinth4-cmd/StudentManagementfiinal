<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_courses_page()
    {
        $user = User::factory()->create();
        Course::create([
            'code' => 'BSCS',
            'name' => 'Computer Science',
            'description' => 'Software engineering',
        ]);

        $response = $this->actingAs($user)->get('/courses');
        $response->assertStatus(200);
        $response->assertSee('BSCS');
        $response->assertSee('Computer Science');
    }

    public function test_js_ajax_can_create_course_returning_json()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/courses', [
                'code' => 'BSIT',
                'name' => 'Information Technology',
                'description' => 'Web technologies',
            ]);

        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'data' => [
                'code' => 'BSIT',
                'name' => 'Information Technology',
            ]
        ]);

        $this->assertDatabaseHas('courses', [
            'code' => 'BSIT',
        ]);
    }

    public function test_js_ajax_can_update_course_returning_json()
    {
        $user = User::factory()->create();
        $course = Course::create([
            'code' => 'BSIS',
            'name' => 'Information Systems',
        ]);

        $response = $this->actingAs($user)
            ->putJson("/courses/{$course->id}", [
                'code' => 'BSIS-UPD',
                'name' => 'Information Systems Updated',
                'description' => 'New Description',
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'code' => 'BSIS-UPD',
            ]
        ]);
    }

    public function test_js_ajax_can_delete_course_returning_json()
    {
        $user = User::factory()->create();
        $course = Course::create([
            'code' => 'BSEMC',
            'name' => 'Entertainment and Multimedia Computing',
        ]);

        $response = $this->actingAs($user)
            ->deleteJson("/courses/{$course->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'id' => $course->id
        ]);

        $this->assertDatabaseMissing('courses', [
            'id' => $course->id
        ]);
    }
}
