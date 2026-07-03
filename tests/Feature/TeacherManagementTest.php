<?php

namespace Tests\Feature;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_view_teacher_list(): void
    {
        $teacherUser = User::factory()->create(['name' => 'Dr. Khalid Hossein', 'role' => 'teacher']);
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'teacher_id' => 'TCH-101',
            'department' => 'CSE',
            'designation' => 'Professor',
            'phone' => '01700000002',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.teachers'));

        $response->assertStatus(200);
        $response->assertSee('Dr. Khalid Hossein');
        $response->assertSee('TCH-101');
    }

    public function test_admin_can_search_teachers_by_name(): void
    {
        $user1 = User::factory()->create(['name' => 'Dr. Khalid Hossein', 'role' => 'teacher']);
        $teacher1 = Teacher::create([
            'user_id' => $user1->id,
            'teacher_id' => 'TCH-101',
            'department' => 'CSE',
            'designation' => 'Professor',
        ]);

        $user2 = User::factory()->create(['name' => 'Alice Smith', 'role' => 'teacher']);
        $teacher2 = Teacher::create([
            'user_id' => $user2->id,
            'teacher_id' => 'TCH-102',
            'department' => 'EEE',
            'designation' => 'Lecturer',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.teachers', ['search' => 'Khalid']));

        $response->assertStatus(200);
        $response->assertSee('Dr. Khalid Hossein');
        $response->assertDontSee('Alice Smith');
    }

    public function test_admin_can_search_teachers_by_teacher_id(): void
    {
        $user1 = User::factory()->create(['name' => 'Dr. Khalid Hossein', 'role' => 'teacher']);
        $teacher1 = Teacher::create([
            'user_id' => $user1->id,
            'teacher_id' => 'TCH-111',
            'department' => 'CSE',
            'designation' => 'Professor',
        ]);

        $user2 = User::factory()->create(['name' => 'Alice Smith', 'role' => 'teacher']);
        $teacher2 = Teacher::create([
            'user_id' => $user2->id,
            'teacher_id' => 'TCH-222',
            'department' => 'EEE',
            'designation' => 'Lecturer',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.teachers', ['search' => '111']));

        $response->assertStatus(200);
        $response->assertSee('TCH-111');
        $response->assertDontSee('TCH-222');
    }

    public function test_admin_can_search_teachers_by_department(): void
    {
        $user1 = User::factory()->create(['name' => 'Dr. Khalid Hossein', 'role' => 'teacher']);
        $teacher1 = Teacher::create([
            'user_id' => $user1->id,
            'teacher_id' => 'TCH-111',
            'department' => 'CSE',
            'designation' => 'Professor',
        ]);

        $user2 = User::factory()->create(['name' => 'Alice Smith', 'role' => 'teacher']);
        $teacher2 = Teacher::create([
            'user_id' => $user2->id,
            'teacher_id' => 'TCH-222',
            'department' => 'EEE',
            'designation' => 'Lecturer',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.teachers', ['search' => 'CSE']));

        $response->assertStatus(200);
        $response->assertSee('TCH-111');
        $response->assertDontSee('TCH-222');
    }

    public function test_admin_can_create_teacher_with_valid_data(): void
    {
        $data = [
            'name' => 'New Teacher',
            'email' => 'teacher_new@unitrack.test',
            'password' => 'password123',
            'teacher_id' => 'TCH-999',
            'department' => 'Mechanical Engineering',
            'designation' => 'Assistant Professor',
            'phone' => '01712345678',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.teachers.store'), $data);

        $response->assertRedirect(route('admin.teachers'));
        $this->assertDatabaseHas('users', ['email' => 'teacher_new@unitrack.test', 'role' => 'teacher']);
        $this->assertDatabaseHas('teachers', ['teacher_id' => 'TCH-999', 'designation' => 'Assistant Professor']);
    }

    public function test_create_teacher_validation_errors(): void
    {
        $invalidData = [
            'name' => '', // Required
            'email' => 'invalid-email', // Needs valid email
            'password' => '123', // Too short
            'teacher_id' => '', // Required
            'department' => '', // Required
            'designation' => '', // Required
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.teachers.store'), $invalidData);

        $response->assertSessionHasErrors(['name', 'email', 'password', 'teacher_id', 'department', 'designation']);
    }

    public function test_admin_can_update_teacher_details(): void
    {
        $teacherUser = User::factory()->create(['name' => 'Old Name', 'role' => 'teacher']);
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'teacher_id' => 'TCH-OLD',
            'department' => 'CSE',
            'designation' => 'Lecturer',
        ]);

        $updateData = [
            'name' => 'New Name',
            'email' => $teacherUser->email, // keep same email
            'teacher_id' => 'TCH-NEW',
            'department' => 'ME',
            'designation' => 'Assistant Professor',
            'phone' => '01800000001',
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.teachers.update', $teacher), $updateData);

        $response->assertRedirect(route('admin.teachers'));
        $this->assertDatabaseHas('users', ['id' => $teacherUser->id, 'name' => 'New Name']);
        $this->assertDatabaseHas('teachers', ['id' => $teacher->id, 'teacher_id' => 'TCH-NEW', 'designation' => 'Assistant Professor']);
    }

    public function test_admin_can_delete_teacher(): void
    {
        $teacherUser = User::factory()->create(['role' => 'teacher']);
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'teacher_id' => 'TCH-DEL',
            'department' => 'CSE',
            'designation' => 'Lecturer',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.teachers.destroy', $teacher));

        $response->assertRedirect(route('admin.teachers'));
        $this->assertDatabaseMissing('users', ['id' => $teacherUser->id]);
        $this->assertDatabaseMissing('teachers', ['id' => $teacher->id]);
    }

    public function test_non_admin_cannot_access_teacher_management(): void
    {
        $studentUser = User::factory()->create(['role' => 'student']);
        $teacherUser = User::factory()->create(['role' => 'teacher']);

        // Student tries to access
        $this->actingAs($studentUser)->get(route('admin.teachers'))->assertStatus(403);
        $this->actingAs($studentUser)->post(route('admin.teachers.store'), [])->assertStatus(403);

        // Teacher tries to access
        $this->actingAs($teacherUser)->get(route('admin.teachers'))->assertStatus(403);
        $this->actingAs($teacherUser)->post(route('admin.teachers.store'), [])->assertStatus(403);
    }
}
