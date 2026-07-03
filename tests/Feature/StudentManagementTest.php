<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_view_student_list(): void
    {
        $studentUser = User::factory()->create(['name' => 'Alice Dev', 'role' => 'student']);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_id' => 'STU-101',
            'department' => 'CSE',
            'semester' => '1st',
            'batch' => '2023',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.students'));

        $response->assertStatus(200);
        $response->assertSee('Alice Dev');
        $response->assertSee('STU-101');
    }

    public function test_admin_can_search_students_by_name(): void
    {
        $user1 = User::factory()->create(['name' => 'John Doe', 'role' => 'student']);
        $student1 = Student::create([
            'user_id' => $user1->id,
            'student_id' => 'STU-001',
            'department' => 'CSE',
            'semester' => '1st',
            'batch' => '2023',
        ]);

        $user2 = User::factory()->create(['name' => 'Alice Smith', 'role' => 'student']);
        $student2 = Student::create([
            'user_id' => $user2->id,
            'student_id' => 'STU-002',
            'department' => 'EEE',
            'semester' => '1st',
            'batch' => '2023',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.students', ['search' => 'John']));

        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertDontSee('Alice Smith');
    }

    public function test_admin_can_search_students_by_student_id(): void
    {
        $user1 = User::factory()->create(['name' => 'John Doe', 'role' => 'student']);
        $student1 = Student::create([
            'user_id' => $user1->id,
            'student_id' => 'STU-111',
            'department' => 'CSE',
            'semester' => '1st',
            'batch' => '2023',
        ]);

        $user2 = User::factory()->create(['name' => 'Alice Smith', 'role' => 'student']);
        $student2 = Student::create([
            'user_id' => $user2->id,
            'student_id' => 'STU-222',
            'department' => 'EEE',
            'semester' => '1st',
            'batch' => '2023',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.students', ['search' => '111']));

        $response->assertStatus(200);
        $response->assertSee('STU-111');
        $response->assertDontSee('STU-222');
    }

    public function test_admin_can_search_students_by_department(): void
    {
        $user1 = User::factory()->create(['name' => 'John Doe', 'role' => 'student']);
        $student1 = Student::create([
            'user_id' => $user1->id,
            'student_id' => 'STU-111',
            'department' => 'CSE',
            'semester' => '1st',
            'batch' => '2023',
        ]);

        $user2 = User::factory()->create(['name' => 'Alice Smith', 'role' => 'student']);
        $student2 = Student::create([
            'user_id' => $user2->id,
            'student_id' => 'STU-222',
            'department' => 'EEE',
            'semester' => '1st',
            'batch' => '2023',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.students', ['search' => 'CSE']));

        $response->assertStatus(200);
        $response->assertSee('STU-111');
        $response->assertDontSee('STU-222');
    }

    public function test_admin_can_create_student_with_valid_data(): void
    {
        $data = [
            'name' => 'Bob Builder',
            'email' => 'bob@unitrack.test',
            'password' => 'password123',
            'student_id' => 'STU-999',
            'department' => 'Civil Engineering',
            'semester' => '3rd',
            'batch' => '2021',
            'phone' => '01712345678',
            'address' => 'KUET Hall',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.students.store'), $data);

        $response->assertRedirect(route('admin.students'));
        $this->assertDatabaseHas('users', ['email' => 'bob@unitrack.test', 'role' => 'student']);
        $this->assertDatabaseHas('students', ['student_id' => 'STU-999', 'department' => 'Civil Engineering']);
    }

    public function test_create_student_validation_errors(): void
    {
        $invalidData = [
            'name' => '', // Required
            'email' => 'invalid-email', // Needs valid email
            'password' => '123', // Too short
            'student_id' => '', // Required
            'department' => '', // Required
            'semester' => '', // Required
            'batch' => '', // Required
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.students.store'), $invalidData);

        $response->assertSessionHasErrors(['name', 'email', 'password', 'student_id', 'department', 'semester', 'batch']);
    }

    public function test_admin_can_update_student_details(): void
    {
        $studentUser = User::factory()->create(['name' => 'Old Name', 'role' => 'student']);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_id' => 'STU-OLD',
            'department' => 'CSE',
            'semester' => '4th',
            'batch' => '2020',
        ]);

        $updateData = [
            'name' => 'New Name',
            'email' => $studentUser->email, // keep same email
            'student_id' => 'STU-NEW',
            'department' => 'ME',
            'semester' => '5th',
            'batch' => '2020',
            'phone' => '01800000001',
            'address' => 'New Address',
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.students.update', $student), $updateData);

        $response->assertRedirect(route('admin.students'));
        $this->assertDatabaseHas('users', ['id' => $studentUser->id, 'name' => 'New Name']);
        $this->assertDatabaseHas('students', ['id' => $student->id, 'student_id' => 'STU-NEW', 'department' => 'ME']);
    }

    public function test_admin_can_delete_student(): void
    {
        $studentUser = User::factory()->create(['role' => 'student']);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_id' => 'STU-DEL',
            'department' => 'CSE',
            'semester' => '1st',
            'batch' => '2023',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.students.destroy', $student));

        $response->assertRedirect(route('admin.students'));
        $this->assertDatabaseMissing('users', ['id' => $studentUser->id]);
        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }

    public function test_non_admin_cannot_access_student_management(): void
    {
        $studentUser = User::factory()->create(['role' => 'student']);
        $teacherUser = User::factory()->create(['role' => 'teacher']);

        // Student tries to access
        $this->actingAs($studentUser)->get(route('admin.students'))->assertStatus(403);
        $this->actingAs($studentUser)->post(route('admin.students.store'), [])->assertStatus(403);

        // Teacher tries to access
        $this->actingAs($teacherUser)->get(route('admin.students'))->assertStatus(403);
        $this->actingAs($teacherUser)->post(route('admin.students.store'), [])->assertStatus(403);
    }
}
