<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private Teacher $teacher;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);

        $teacherUser = User::factory()->create(['role' => 'teacher']);
        $this->teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'teacher_id' => 'TCH-001',
            'department' => 'CSE',
            'designation' => 'Professor',
        ]);
    }

    public function test_admin_can_view_course_list(): void
    {
        Course::create([
            'course_code' => 'CSE-3200',
            'course_title' => 'Information System Design Lab',
            'department' => 'CSE',
            'semester' => '6th',
            'credit' => 1.5,
            'teacher_id' => $this->teacher->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.courses'));

        $response->assertStatus(200);
        $response->assertSee('CSE-3200');
        $response->assertSee('Information System Design Lab');
    }

    public function test_admin_can_search_courses_by_title_or_code(): void
    {
        Course::create([
            'course_code' => 'CSE-3200',
            'course_title' => 'Information System Design Lab',
            'department' => 'CSE',
            'semester' => '6th',
            'credit' => 1.5,
        ]);

        Course::create([
            'course_code' => 'EEE-3100',
            'course_title' => 'Electronics Circuit',
            'department' => 'EEE',
            'semester' => '5th',
            'credit' => 3.0,
        ]);

        // Search by code
        $response = $this->actingAs($this->admin)->get(route('admin.courses', ['search' => 'CSE']));
        $response->assertStatus(200);
        $response->assertSee('CSE-3200');
        $response->assertDontSee('EEE-3100');

        // Search by title
        $response = $this->actingAs($this->admin)->get(route('admin.courses', ['search' => 'Electronics']));
        $response->assertStatus(200);
        $response->assertSee('EEE-3100');
        $response->assertDontSee('CSE-3200');
    }

    public function test_admin_can_create_course_with_valid_data(): void
    {
        $data = [
            'course_code' => 'CSE-4101',
            'course_title' => 'Artificial Intelligence',
            'department' => 'CSE',
            'semester' => '7th',
            'credit' => 3.0,
            'teacher_id' => $this->teacher->id,
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.courses.store'), $data);

        $response->assertRedirect(route('admin.courses'));
        $this->assertDatabaseHas('courses', [
            'course_code' => 'CSE-4101',
            'course_title' => 'Artificial Intelligence',
            'teacher_id' => $this->teacher->id,
        ]);
    }

    public function test_create_course_validation_errors(): void
    {
        $invalidData = [
            'course_code' => '', // Required
            'course_title' => '', // Required
            'department' => '', // Required
            'semester' => '', // Required
            'credit' => 'invalid-credit', // Needs numeric
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.courses.store'), $invalidData);

        $response->assertSessionHasErrors(['course_code', 'course_title', 'department', 'semester', 'credit']);
    }

    public function test_admin_can_update_course_details(): void
    {
        $course = Course::create([
            'course_code' => 'CSE-3200',
            'course_title' => 'Old Title',
            'department' => 'CSE',
            'semester' => '6th',
            'credit' => 1.5,
        ]);

        $updateData = [
            'course_code' => 'CSE-3200',
            'course_title' => 'New Title',
            'department' => 'CSE',
            'semester' => '6th',
            'credit' => 1.5,
            'teacher_id' => $this->teacher->id,
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.courses.update', $course), $updateData);

        $response->assertRedirect(route('admin.courses'));
        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'course_title' => 'New Title',
            'teacher_id' => $this->teacher->id,
        ]);
    }

    public function test_admin_can_delete_course(): void
    {
        $course = Course::create([
            'course_code' => 'CSE-3200',
            'course_title' => 'Information System Design Lab',
            'department' => 'CSE',
            'semester' => '6th',
            'credit' => 1.5,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.courses.destroy', $course));

        $response->assertRedirect(route('admin.courses'));
        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }

    public function test_non_admin_cannot_access_course_management(): void
    {
        $studentUser = User::factory()->create(['role' => 'student']);
        $teacherUser = User::factory()->create(['role' => 'teacher']);

        // Student tries to access
        $this->actingAs($studentUser)->get(route('admin.courses'))->assertStatus(403);
        $this->actingAs($studentUser)->post(route('admin.courses.store'), [])->assertStatus(403);

        // Teacher tries to access
        $this->actingAs($teacherUser)->get(route('admin.courses'))->assertStatus(403);
        $this->actingAs($teacherUser)->post(route('admin.courses.store'), [])->assertStatus(403);
    }
}
