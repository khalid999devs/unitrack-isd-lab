<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_student_can_view_and_update_own_profile(): void
    {
        $studentUser = User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@unitrack.test',
            'role' => 'student',
        ]);

        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_id' => 'STU-2207035',
            'department' => 'Computer Science and Engineering',
            'semester' => '6th',
            'batch' => '2022',
            'phone' => '01700000001',
            'address' => 'KUET Campus',
        ]);

        $this->actingAs($studentUser)
            ->get(route('student.profile'))
            ->assertOk()
            ->assertSee('Student User')
            ->assertSee('STU-2207035')
            ->assertSee('Computer Science and Engineering');

        $this->actingAs($studentUser)
            ->post(route('student.profile.update'), [
                'name' => 'Updated Student',
                'email' => 'updated.student@unitrack.test',
                'phone' => '01800000001',
                'address' => 'Updated Student Address',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $studentUser->id,
            'name' => 'Updated Student',
            'email' => 'updated.student@unitrack.test',
            'role' => 'student',
        ]);

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'student_id' => 'STU-2207035',
            'phone' => '01800000001',
            'address' => 'Updated Student Address',
        ]);
    }

    public function test_teacher_can_view_and_update_own_profile(): void
    {
        $teacherUser = User::factory()->create([
            'name' => 'Teacher User',
            'email' => 'teacher@unitrack.test',
            'role' => 'teacher',
        ]);

        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'teacher_id' => 'TCH-1001',
            'department' => 'Computer Science and Engineering',
            'designation' => 'Lecturer',
            'phone' => '01700000002',
        ]);

        $this->actingAs($teacherUser)
            ->get(route('teacher.profile'))
            ->assertOk()
            ->assertSee('Teacher User')
            ->assertSee('TCH-1001')
            ->assertSee('Lecturer');

        $this->actingAs($teacherUser)
            ->post(route('teacher.profile.update'), [
                'name' => 'Updated Teacher',
                'email' => 'updated.teacher@unitrack.test',
                'phone' => '01800000002',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $teacherUser->id,
            'name' => 'Updated Teacher',
            'email' => 'updated.teacher@unitrack.test',
            'role' => 'teacher',
        ]);

        $this->assertDatabaseHas('teachers', [
            'id' => $teacher->id,
            'teacher_id' => 'TCH-1001',
            'phone' => '01800000002',
        ]);
    }

    public function test_profile_updates_validate_required_fields_and_unique_email(): void
    {
        User::factory()->create([
            'email' => 'taken@unitrack.test',
            'role' => 'student',
        ]);

        $studentUser = User::factory()->create([
            'email' => 'student@unitrack.test',
            'role' => 'student',
        ]);

        Student::create([
            'user_id' => $studentUser->id,
            'student_id' => 'STU-2207035',
            'department' => 'Computer Science and Engineering',
            'semester' => '6th',
            'batch' => '2022',
        ]);

        $this->actingAs($studentUser)
            ->post(route('student.profile.update'), [
                'name' => '',
                'email' => 'taken@unitrack.test',
            ])
            ->assertSessionHasErrors(['name', 'email']);
    }

    public function test_roles_cannot_submit_other_role_profile_updates(): void
    {
        $studentUser = User::factory()->create(['role' => 'student']);
        $teacherUser = User::factory()->create(['role' => 'teacher']);
        $adminUser = User::factory()->create(['role' => 'admin']);

        $this->actingAs($studentUser)
            ->post(route('teacher.profile.update'), [])
            ->assertForbidden();

        $this->actingAs($teacherUser)
            ->post(route('student.profile.update'), [])
            ->assertForbidden();

        $this->actingAs($adminUser)
            ->post(route('student.profile.update'), [])
            ->assertForbidden();

        $this->actingAs($adminUser)
            ->post(route('teacher.profile.update'), [])
            ->assertForbidden();
    }
}
