<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Notice;
use App\Models\Student;
use App\Models\StudyMaterial;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class V1ContentActionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_teacher_can_manage_materials_and_student_can_download_them(): void
    {
        [
            'teacherUser' => $teacherUser,
            'studentUser' => $studentUser,
            'course' => $course,
        ] = $this->createAcademicFixture();

        $this->actingAs($teacherUser)
            ->post(route('teacher.materials.store'), [
                'course_id' => $course->id,
                'title' => 'Week 5 Notes',
                'description' => 'Transactions and recovery notes.',
                'file_path' => 'materials/week-5-notes.pdf',
            ])->assertRedirect(route('teacher.materials'));

        $material = StudyMaterial::firstOrFail();

        $this->assertDatabaseHas('study_materials', [
            'title' => 'Week 5 Notes',
            'teacher_id' => $course->teacher_id,
        ]);

        $this->actingAs($teacherUser)
            ->get(route('teacher.materials.edit', $material))
            ->assertOk()
            ->assertSee('Week 5 Notes');

        $this->actingAs($teacherUser)
            ->put(route('teacher.materials.update', $material), [
                'course_id' => $course->id,
                'title' => 'Updated Week 5 Notes',
                'description' => 'Updated resource summary.',
                'file_path' => 'materials/updated-week-5-notes.pdf',
            ])->assertRedirect(route('teacher.materials'));

        $material->refresh();

        $this->actingAs($studentUser)
            ->get(route('student.materials'))
            ->assertOk()
            ->assertSee('Updated Week 5 Notes');

        $download = $this->actingAs($studentUser)
            ->get(route('student.materials.download', $material));

        $download->assertOk();
        $this->assertStringContainsString('attachment', $download->headers->get('content-disposition'));

        $this->actingAs($teacherUser)
            ->delete(route('teacher.materials.destroy', $material))
            ->assertRedirect(route('teacher.materials'));

        $this->assertDatabaseMissing('study_materials', [
            'title' => 'Updated Week 5 Notes',
        ]);
    }

    public function test_teacher_can_create_assignment_and_view_submission_roster(): void
    {
        [
            'teacherUser' => $teacherUser,
            'student' => $student,
            'course' => $course,
        ] = $this->createAcademicFixture();

        $this->actingAs($teacherUser)
            ->post(route('teacher.assignments.store'), [
                'course_id' => $course->id,
                'title' => 'Sprint Review Summary',
                'description' => 'Write the sprint review summary.',
                'deadline' => now()->addDays(3)->format('Y-m-d H:i:s'),
            ])->assertRedirect(route('teacher.assignments'));

        $assignment = Assignment::firstOrFail();

        $this->actingAs($teacherUser)
            ->get(route('teacher.assignments.submissions', $assignment))
            ->assertOk()
            ->assertSee('Sprint Review Summary')
            ->assertSee($student->student_id);
    }

    public function test_admin_and_teacher_notice_actions_feed_role_notice_boards(): void
    {
        [
            'adminUser' => $adminUser,
            'teacherUser' => $teacherUser,
            'studentUser' => $studentUser,
        ] = $this->createAcademicFixture();

        $this->actingAs($adminUser)
            ->post(route('admin.notices.store'), [
                'title' => 'Registration Opens',
                'description' => 'Complete registration this week.',
                'target_role' => 'student',
            ])->assertRedirect(route('admin.notices'));

        $notice = Notice::where('title', 'Registration Opens')->firstOrFail();

        $this->actingAs($studentUser)
            ->get(route('student.notices'))
            ->assertOk()
            ->assertSee('Registration Opens');

        $this->actingAs($adminUser)
            ->put(route('admin.notices.update', $notice), [
                'title' => 'Registration Deadline',
                'description' => 'Complete registration by Thursday.',
                'target_role' => 'student',
            ])->assertRedirect(route('admin.notices'));

        $this->assertDatabaseHas('notices', [
            'title' => 'Registration Deadline',
            'target_role' => 'student',
        ]);

        $this->actingAs($teacherUser)
            ->post(route('teacher.notices.store'), [
                'title' => 'Lab Room Changed',
                'description' => 'Use CSE Lab 2 for the next session.',
                'target_role' => 'student',
            ])->assertRedirect(route('teacher.notices'));

        $this->actingAs($studentUser)
            ->get(route('student.notices'))
            ->assertOk()
            ->assertSee('Registration Deadline')
            ->assertSee('Lab Room Changed');

        $this->actingAs($adminUser)
            ->delete(route('admin.notices.destroy', $notice))
            ->assertRedirect(route('admin.notices'));

        $this->assertDatabaseMissing('notices', [
            'title' => 'Registration Deadline',
        ]);
    }

    /**
     * @return array{
     *     adminUser: User,
     *     teacherUser: User,
     *     studentUser: User,
     *     teacher: Teacher,
     *     student: Student,
     *     course: Course
     * }
     */
    private function createAcademicFixture(): array
    {
        $adminUser = User::factory()->create([
            'role' => 'admin',
            'password' => 'password',
        ]);

        $teacherUser = User::factory()->create([
            'role' => 'teacher',
            'password' => 'password',
        ]);

        $studentUser = User::factory()->create([
            'role' => 'student',
            'password' => 'password',
        ]);

        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'teacher_id' => 'TCH-1001',
            'department' => 'Computer Science and Engineering',
            'designation' => 'Lecturer',
            'phone' => '01700000002',
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

        $course = Course::create([
            'course_code' => 'CSE-3200',
            'course_title' => 'Information System Design Lab',
            'department' => 'Computer Science and Engineering',
            'semester' => '6th',
            'credit' => 1.5,
            'teacher_id' => $teacher->id,
        ]);

        return compact('adminUser', 'teacherUser', 'studentUser', 'teacher', 'student', 'course');
    }
}
