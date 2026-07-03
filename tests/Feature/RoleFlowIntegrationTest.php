<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Notice;
use App\Models\Routine;
use App\Models\Student;
use App\Models\StudyMaterial;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleFlowIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_login_redirects_to_role_dashboard_after_visiting_restricted_page(): void
    {
        ['studentUser' => $studentUser] = $this->createRoleFixtures();

        $this->get(route('teacher.dashboard'))
            ->assertRedirect(route('login'));

        $this->post(route('login.store'), [
            'email' => $studentUser->email,
            'password' => 'password',
        ])->assertRedirect(route('student.dashboard'));
    }

    public function test_each_role_can_render_its_own_frontend_routes(): void
    {
        [
            'adminUser' => $adminUser,
            'studentUser' => $studentUser,
            'teacherUser' => $teacherUser,
        ] = $this->createRoleFixtures();

        foreach ($this->studentRoutes() as $routeName) {
            $this->actingAs($studentUser)->get(route($routeName))->assertOk();
        }

        foreach ($this->teacherRoutes() as $routeName) {
            $this->actingAs($teacherUser)->get(route($routeName))->assertOk();
        }

        foreach ($this->adminRoutes() as $routeName) {
            $this->actingAs($adminUser)->get(route($routeName))->assertOk();
        }
    }

    public function test_role_middleware_blocks_cross_role_frontend_routes(): void
    {
        [
            'adminUser' => $adminUser,
            'studentUser' => $studentUser,
            'teacherUser' => $teacherUser,
        ] = $this->createRoleFixtures();

        foreach ([...$this->teacherRoutes(), ...$this->adminRoutes()] as $routeName) {
            $this->actingAs($studentUser)->get(route($routeName))->assertForbidden();
        }

        foreach ([...$this->studentRoutes(), ...$this->adminRoutes()] as $routeName) {
            $this->actingAs($teacherUser)->get(route($routeName))->assertForbidden();
        }

        foreach ([...$this->studentRoutes(), ...$this->teacherRoutes()] as $routeName) {
            $this->actingAs($adminUser)->get(route($routeName))->assertForbidden();
        }
    }

    public function test_student_and_teacher_course_pages_use_backend_course_filters(): void
    {
        [
            'studentUser' => $studentUser,
            'teacherUser' => $teacherUser,
        ] = $this->createRoleFixtures();

        $this->actingAs($studentUser)
            ->get(route('student.courses'))
            ->assertOk()
            ->assertSee('CSE-3200')
            ->assertSee('Information System Design Lab')
            ->assertDontSee('EEE-3201');

        $this->actingAs($teacherUser)
            ->get(route('teacher.courses'))
            ->assertOk()
            ->assertSee('CSE-3200')
            ->assertSee('Information System Design Lab')
            ->assertDontSee('EEE-3201');
    }

    /**
     * @return array{
     *     adminUser: User,
     *     studentUser: User,
     *     teacherUser: User,
     *     student: Student,
     *     teacher: Teacher
     * }
     */
    private function createRoleFixtures(): array
    {
        $adminUser = User::factory()->create([
            'email' => 'admin@unitrack.test',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $studentUser = User::factory()->create([
            'email' => 'student@unitrack.test',
            'password' => 'password',
            'role' => 'student',
        ]);

        $teacherUser = User::factory()->create([
            'email' => 'teacher@unitrack.test',
            'password' => 'password',
            'role' => 'teacher',
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

        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'teacher_id' => 'TCH-1001',
            'department' => 'Computer Science and Engineering',
            'designation' => 'Lecturer',
            'phone' => '01700000002',
        ]);

        $otherTeacherUser = User::factory()->create([
            'email' => 'other.teacher@unitrack.test',
            'role' => 'teacher',
        ]);

        $otherTeacher = Teacher::create([
            'user_id' => $otherTeacherUser->id,
            'teacher_id' => 'TCH-2001',
            'department' => 'Electrical Engineering',
            'designation' => 'Assistant Professor',
        ]);

        $course = Course::create([
            'course_code' => 'CSE-3200',
            'course_title' => 'Information System Design Lab',
            'department' => 'Computer Science and Engineering',
            'semester' => '6th',
            'credit' => 1.5,
            'teacher_id' => $teacher->id,
        ]);

        Course::create([
            'course_code' => 'EEE-3201',
            'course_title' => 'Electrical Circuits',
            'department' => 'Electrical Engineering',
            'semester' => '5th',
            'credit' => 3.0,
            'teacher_id' => $otherTeacher->id,
        ]);

        Routine::create([
            'course_id' => $course->id,
            'teacher_id' => $teacher->id,
            'semester' => '6th',
            'batch' => '2022',
            'day' => now()->format('l'),
            'start_time' => '09:00:00',
            'end_time' => '11:00:00',
            'room' => 'CSE Lab 1',
        ]);

        Notice::create([
            'title' => 'Welcome Notice',
            'description' => 'Welcome to UniTrack.',
            'posted_by' => $adminUser->id,
            'target_role' => 'all',
        ]);

        StudyMaterial::create([
            'course_id' => $course->id,
            'teacher_id' => $teacher->id,
            'title' => 'ISD Starter Material',
            'description' => 'Starter material for testing.',
            'file_path' => 'materials/isd-starter.pdf',
        ]);

        Assignment::create([
            'course_id' => $course->id,
            'teacher_id' => $teacher->id,
            'title' => 'Role Flow Assignment',
            'description' => 'Assignment used by integration flow tests.',
            'deadline' => now()->addWeek(),
        ]);

        return compact('adminUser', 'studentUser', 'teacherUser', 'student', 'teacher');
    }

    /**
     * @return list<string>
     */
    private function studentRoutes(): array
    {
        return [
            'student.dashboard',
            'student.courses',
            'student.routine',
            'student.notices',
            'student.materials',
            'student.assignments',
        ];
    }

    /**
     * @return list<string>
     */
    private function teacherRoutes(): array
    {
        return [
            'teacher.dashboard',
            'teacher.courses',
            'teacher.routine',
            'teacher.materials',
            'teacher.assignments',
            'teacher.notices',
        ];
    }

    /**
     * @return list<string>
     */
    private function adminRoutes(): array
    {
        return [
            'admin.dashboard',
            'admin.students',
            'admin.teachers',
            'admin.courses',
            'admin.routines',
            'admin.notices',
        ];
    }
}
