<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Routine;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoutineManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private Teacher $teacher1;

    private Teacher $teacher2;

    private Course $course1;

    private Course $course2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        // Set up Admin User
        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@unitrack.test',
            'password' => 'password',
            'role' => 'admin',
        ]);

        // Set up Teacher 1
        $teacherUser1 = User::create([
            'name' => 'Dr. John Doe',
            'email' => 'john@unitrack.test',
            'password' => 'password',
            'role' => 'teacher',
        ]);
        $this->teacher1 = Teacher::create([
            'user_id' => $teacherUser1->id,
            'teacher_id' => 'TCH-101',
            'department' => 'Computer Science and Engineering',
            'designation' => 'Professor',
            'phone' => '01700000002',
        ]);

        // Set up Teacher 2
        $teacherUser2 = User::create([
            'name' => 'Prof. Jane Smith',
            'email' => 'jane@unitrack.test',
            'password' => 'password',
            'role' => 'teacher',
        ]);
        $this->teacher2 = Teacher::create([
            'user_id' => $teacherUser2->id,
            'teacher_id' => 'TCH-102',
            'department' => 'Electrical Engineering',
            'designation' => 'Assistant Professor',
            'phone' => '01700000003',
        ]);

        // Set up Courses
        $this->course1 = Course::create([
            'course_code' => 'CSE-3200',
            'course_title' => 'Information System Design Lab',
            'department' => 'Computer Science and Engineering',
            'semester' => '6th',
            'credit' => 1.5,
            'teacher_id' => $this->teacher1->id,
        ]);

        $this->course2 = Course::create([
            'course_code' => 'EE-3201',
            'course_title' => 'Electrical Circuits',
            'department' => 'Electrical Engineering',
            'semester' => '5th',
            'credit' => 3.0,
            'teacher_id' => $this->teacher2->id,
        ]);
    }

    public function test_admin_can_view_routine_list(): void
    {
        Routine::create([
            'course_id' => $this->course1->id,
            'teacher_id' => $this->teacher1->id,
            'semester' => '6th',
            'batch' => '2022',
            'day' => 'Sunday',
            'start_time' => '09:00:00',
            'end_time' => '11:00:00',
            'room' => 'CSE Lab 1',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.routines'));

        $response->assertStatus(200);
        $response->assertSee('CSE-3200');
        $response->assertSee('Dr. John Doe');
        $response->assertSee('CSE Lab 1');
    }

    public function test_admin_can_view_create_routine_page(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.routines.create'));

        $response->assertStatus(200);
        $response->assertSee('Add Class Routine');
        $response->assertSee($this->course1->course_title);
        $response->assertSee($this->teacher1->user->name);
    }

    public function test_admin_can_create_routine_with_valid_data(): void
    {
        $data = [
            'course_id' => $this->course1->id,
            'teacher_id' => $this->teacher1->id,
            'semester' => '6th',
            'batch' => '2022',
            'day' => 'Monday',
            'start_time' => '10:00',
            'end_time' => '12:00',
            'room' => 'Room 404',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.routines.store'), $data);

        $response->assertRedirect(route('admin.routines'));
        $response->assertSessionHas('success', 'Routine created successfully.');

        $this->assertDatabaseHas('routines', [
            'course_id' => $this->course1->id,
            'teacher_id' => $this->teacher1->id,
            'semester' => '6th',
            'batch' => '2022',
            'day' => 'Monday',
            'room' => 'Room 404',
        ]);
    }

    public function test_create_routine_validation_errors(): void
    {
        // empty input validation
        $response = $this->actingAs($this->admin)
            ->post(route('admin.routines.store'), []);

        $response->assertSessionHasErrors(['course_id', 'teacher_id', 'semester', 'batch', 'day', 'start_time', 'end_time', 'room']);

        // end_time must be after start_time validation
        $data = [
            'course_id' => $this->course1->id,
            'teacher_id' => $this->teacher1->id,
            'semester' => '6th',
            'batch' => '2022',
            'day' => 'Monday',
            'start_time' => '12:00',
            'end_time' => '10:00',
            'room' => 'Room 404',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.routines.store'), $data);

        $response->assertSessionHasErrors(['end_time']);
    }

    public function test_admin_can_view_edit_routine_page(): void
    {
        $routine = Routine::create([
            'course_id' => $this->course1->id,
            'teacher_id' => $this->teacher1->id,
            'semester' => '6th',
            'batch' => '2022',
            'day' => 'Sunday',
            'start_time' => '09:00:00',
            'end_time' => '11:00:00',
            'room' => 'CSE Lab 1',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.routines.edit', $routine->id));

        $response->assertStatus(200);
        $response->assertSee('Edit Class Routine');
        $response->assertSee('CSE Lab 1');
    }

    public function test_admin_can_update_routine_details(): void
    {
        $routine = Routine::create([
            'course_id' => $this->course1->id,
            'teacher_id' => $this->teacher1->id,
            'semester' => '6th',
            'batch' => '2022',
            'day' => 'Sunday',
            'start_time' => '09:00:00',
            'end_time' => '11:00:00',
            'room' => 'CSE Lab 1',
        ]);

        $updateData = [
            'course_id' => $this->course2->id,
            'teacher_id' => $this->teacher2->id,
            'semester' => '5th',
            'batch' => '2021',
            'day' => 'Tuesday',
            'start_time' => '14:00',
            'end_time' => '16:00',
            'room' => 'Room 501',
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.routines.update', $routine->id), $updateData);

        $response->assertRedirect(route('admin.routines'));
        $response->assertSessionHas('success', 'Routine updated successfully.');

        $this->assertDatabaseHas('routines', [
            'id' => $routine->id,
            'course_id' => $this->course2->id,
            'teacher_id' => $this->teacher2->id,
            'semester' => '5th',
            'batch' => '2021',
            'day' => 'Tuesday',
            'room' => 'Room 501',
        ]);
    }

    public function test_admin_can_delete_routine(): void
    {
        $routine = Routine::create([
            'course_id' => $this->course1->id,
            'teacher_id' => $this->teacher1->id,
            'semester' => '6th',
            'batch' => '2022',
            'day' => 'Sunday',
            'start_time' => '09:00:00',
            'end_time' => '11:00:00',
            'room' => 'CSE Lab 1',
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.routines.destroy', $routine->id));

        $response->assertRedirect(route('admin.routines'));
        $response->assertSessionHas('success', 'Routine deleted successfully.');

        $this->assertDatabaseMissing('routines', ['id' => $routine->id]);
    }

    public function test_student_can_view_own_routine_matching_semester_and_batch(): void
    {
        $studentUser = User::create([
            'name' => 'Student User',
            'email' => 'student@unitrack.test',
            'password' => 'password',
            'role' => 'student',
        ]);
        Student::create([
            'user_id' => $studentUser->id,
            'student_id' => 'STU-2207035',
            'department' => 'Computer Science and Engineering',
            'semester' => '6th',
            'batch' => '2022',
            'phone' => '01700000001',
            'address' => 'KUET Campus',
        ]);

        // Routine matching student details
        Routine::create([
            'course_id' => $this->course1->id,
            'teacher_id' => $this->teacher1->id,
            'semester' => '6th',
            'batch' => '2022',
            'day' => 'Sunday',
            'start_time' => '09:00:00',
            'end_time' => '11:00:00',
            'room' => 'CSE Lab 1',
        ]);

        // Routine not matching student details
        Routine::create([
            'course_id' => $this->course2->id,
            'teacher_id' => $this->teacher2->id,
            'semester' => '5th',
            'batch' => '2021',
            'day' => 'Tuesday',
            'start_time' => '14:00:00',
            'end_time' => '16:00:00',
            'room' => 'Room 501',
        ]);

        $response = $this->actingAs($studentUser)
            ->get(route('student.routine'));

        $response->assertStatus(200);
        $response->assertSee('CSE Lab 1');
        $response->assertSee('CSE-3200');
        $response->assertDontSee('Room 501');
        $response->assertDontSee('EE-3201');
    }

    public function test_teacher_can_view_assigned_routines(): void
    {
        $teacherUser = $this->teacher1->user;

        // Routine matching teacher 1
        Routine::create([
            'course_id' => $this->course1->id,
            'teacher_id' => $this->teacher1->id,
            'semester' => '6th',
            'batch' => '2022',
            'day' => 'Sunday',
            'start_time' => '09:00:00',
            'end_time' => '11:00:00',
            'room' => 'CSE Lab 1',
        ]);

        // Routine not matching teacher 1 (matches teacher 2)
        Routine::create([
            'course_id' => $this->course2->id,
            'teacher_id' => $this->teacher2->id,
            'semester' => '5th',
            'batch' => '2021',
            'day' => 'Tuesday',
            'start_time' => '14:00:00',
            'end_time' => '16:00:00',
            'room' => 'Room 501',
        ]);

        $response = $this->actingAs($teacherUser)
            ->get(route('teacher.routine'));

        $response->assertStatus(200);
        $response->assertSee('CSE Lab 1');
        $response->assertSee('CSE-3200');
        $response->assertDontSee('Room 501');
        $response->assertDontSee('EE-3201');
    }

    public function test_non_admin_cannot_access_routine_management_endpoints(): void
    {
        $studentUser = User::create([
            'name' => 'Student User',
            'email' => 'student@unitrack.test',
            'password' => 'password',
            'role' => 'student',
        ]);

        $routine = Routine::create([
            'course_id' => $this->course1->id,
            'teacher_id' => $this->teacher1->id,
            'semester' => '6th',
            'batch' => '2022',
            'day' => 'Sunday',
            'start_time' => '09:00:00',
            'end_time' => '11:00:00',
            'room' => 'CSE Lab 1',
        ]);

        $endpoints = [
            ['method' => 'GET', 'url' => route('admin.routines')],
            ['method' => 'GET', 'url' => route('admin.routines.create')],
            ['method' => 'POST', 'url' => route('admin.routines.store')],
            ['method' => 'GET', 'url' => route('admin.routines.edit', $routine->id)],
            ['method' => 'PUT', 'url' => route('admin.routines.update', $routine->id)],
            ['method' => 'DELETE', 'url' => route('admin.routines.destroy', $routine->id)],
        ];

        foreach ($endpoints as $endpoint) {
            $response = $this->actingAs($studentUser)
                ->json($endpoint['method'], $endpoint['url']);

            $response->assertStatus(403);
        }
    }
}
