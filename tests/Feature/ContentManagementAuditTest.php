<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Course;
use App\Models\Notice;
use App\Models\Student;
use App\Models\StudyMaterial;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ContentManagementAuditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        Storage::fake('local');
    }

    public function test_admin_can_manage_materials_assignments_and_submission_files(): void
    {
        $fixture = $this->createAcademicFixture();

        $this->actingAs($fixture['adminUser'])
            ->post(route('admin.materials.store'), [
                'course_id' => $fixture['course']->id,
                'title' => 'Unsafe Resource',
                'material_file' => UploadedFile::fake()->create('resource.exe', 12, 'application/octet-stream'),
            ])
            ->assertSessionHasErrors('material_file');

        $this->actingAs($fixture['adminUser'])
            ->post(route('admin.materials.store'), [
                'course_id' => $fixture['course']->id,
                'title' => 'Admin Resource',
                'description' => 'Managed from the admin workspace.',
                'material_file' => UploadedFile::fake()->create('resource.pdf', 32, 'application/pdf'),
            ])
            ->assertRedirect(route('admin.materials'));

        $material = StudyMaterial::where('title', 'Admin Resource')->firstOrFail();
        $originalPath = $material->file_path;
        Storage::assertExists($originalPath);

        $this->actingAs($fixture['adminUser'])
            ->put(route('admin.materials.update', $material), [
                'course_id' => $fixture['course']->id,
                'title' => 'Updated Admin Resource',
                'description' => 'Updated resource.',
                'material_file' => UploadedFile::fake()->create('updated.pdf', 32, 'application/pdf'),
            ])
            ->assertRedirect(route('admin.materials'));

        $material->refresh();
        Storage::assertMissing($originalPath);
        Storage::assertExists($material->file_path);

        $this->actingAs($fixture['adminUser'])
            ->get(route('admin.materials.download', $material))
            ->assertOk()
            ->assertDownload('updated-admin-resource.pdf');

        $this->actingAs($fixture['adminUser'])
            ->post(route('admin.assignments.store'), [
                'course_id' => $fixture['course']->id,
                'title' => 'Admin Assignment',
                'description' => 'Created during the application audit.',
                'deadline' => now()->addWeek()->format('Y-m-d H:i:s'),
            ])
            ->assertRedirect(route('admin.assignments'));

        $assignment = Assignment::where('title', 'Admin Assignment')->firstOrFail();

        Storage::put('assignment-submissions/audit.pdf', 'submission');
        $submission = AssignmentSubmission::create([
            'assignment_id' => $assignment->id,
            'student_id' => $fixture['student']->id,
            'submission_text' => 'Audited submission note.',
            'file_path' => 'assignment-submissions/audit.pdf',
            'submitted_at' => now(),
        ]);

        $this->actingAs($fixture['adminUser'])
            ->get(route('admin.assignments.submissions', $assignment))
            ->assertOk()
            ->assertSee('Audited submission note.');

        $this->actingAs($fixture['adminUser'])
            ->get(route('admin.assignments.submissions.download', $submission))
            ->assertOk()
            ->assertDownload('stu-1001-admin-assignment.pdf');

        $this->actingAs($fixture['adminUser'])
            ->delete(route('admin.assignments.destroy', $assignment))
            ->assertRedirect(route('admin.assignments'));

        Storage::assertMissing('assignment-submissions/audit.pdf');
        $this->assertDatabaseMissing('assignments', ['id' => $assignment->id]);

        $materialPath = $material->file_path;
        $this->actingAs($fixture['adminUser'])
            ->delete(route('admin.materials.destroy', $material))
            ->assertRedirect(route('admin.materials'));
        Storage::assertMissing($materialPath);
    }

    public function test_teacher_content_actions_are_limited_to_the_content_owner(): void
    {
        $fixture = $this->createAcademicFixture();

        $otherTeacherUser = User::factory()->create(['role' => 'teacher']);
        Teacher::create([
            'user_id' => $otherTeacherUser->id,
            'teacher_id' => 'TCH-2002',
            'department' => 'Computer Science and Engineering',
            'designation' => 'Lecturer',
        ]);

        $material = StudyMaterial::create([
            'course_id' => $fixture['course']->id,
            'teacher_id' => $fixture['teacher']->id,
            'title' => 'Owned Material',
            'file_path' => null,
        ]);

        $assignment = Assignment::create([
            'course_id' => $fixture['course']->id,
            'teacher_id' => $fixture['teacher']->id,
            'title' => 'Owned Assignment',
            'description' => 'Only the owner can manage this.',
            'deadline' => now()->addDays(3),
        ]);

        $notice = Notice::create([
            'title' => 'Owned Notice',
            'description' => 'Only the author can manage this.',
            'posted_by' => $fixture['teacherUser']->id,
            'target_role' => 'student',
        ]);

        $this->actingAs($otherTeacherUser)
            ->get(route('teacher.materials.edit', $material))
            ->assertForbidden();
        $this->actingAs($otherTeacherUser)
            ->get(route('teacher.assignments.edit', $assignment))
            ->assertForbidden();
        $this->actingAs($otherTeacherUser)
            ->get(route('teacher.notices.edit', $notice))
            ->assertForbidden();

        $this->actingAs($fixture['teacherUser'])
            ->put(route('teacher.assignments.update', $assignment), [
                'course_id' => $fixture['course']->id,
                'title' => 'Updated Owned Assignment',
                'description' => 'Updated by its owner.',
                'deadline' => now()->addDays(5)->format('Y-m-d H:i:s'),
            ])
            ->assertRedirect(route('teacher.assignments'));

        $this->actingAs($fixture['teacherUser'])
            ->put(route('teacher.notices.update', $notice), [
                'title' => 'Updated Owned Notice',
                'description' => 'Updated by its author.',
                'target_role' => 'student',
            ])
            ->assertRedirect(route('teacher.notices'));

        $this->assertDatabaseHas('assignments', ['title' => 'Updated Owned Assignment']);
        $this->assertDatabaseHas('notices', ['title' => 'Updated Owned Notice']);
    }

    public function test_student_content_is_scoped_by_department_and_semester(): void
    {
        $fixture = $this->createAcademicFixture();

        $otherTeacherUser = User::factory()->create(['role' => 'teacher']);
        $otherTeacher = Teacher::create([
            'user_id' => $otherTeacherUser->id,
            'teacher_id' => 'TCH-EEE-1',
            'department' => 'Electrical Engineering',
            'designation' => 'Lecturer',
        ]);
        $otherCourse = Course::create([
            'course_code' => 'EEE-3100',
            'course_title' => 'Signals and Systems',
            'department' => 'Electrical Engineering',
            'semester' => '6th',
            'credit' => 3,
            'teacher_id' => $otherTeacher->id,
        ]);

        Storage::put('study-materials/other.pdf', 'other department');
        $otherMaterial = StudyMaterial::create([
            'course_id' => $otherCourse->id,
            'teacher_id' => $otherTeacher->id,
            'title' => 'Electrical Material',
            'file_path' => 'study-materials/other.pdf',
        ]);
        $otherAssignment = Assignment::create([
            'course_id' => $otherCourse->id,
            'teacher_id' => $otherTeacher->id,
            'title' => 'Electrical Assignment',
            'description' => 'Not available to CSE students.',
            'deadline' => now()->addDays(3),
        ]);

        $this->actingAs($fixture['studentUser'])
            ->get(route('student.courses'))
            ->assertOk()
            ->assertSee($fixture['course']->course_code)
            ->assertDontSee($otherCourse->course_code);

        $this->actingAs($fixture['studentUser'])
            ->get(route('student.materials'))
            ->assertOk()
            ->assertDontSee('Electrical Material');
        $this->actingAs($fixture['studentUser'])
            ->get(route('student.assignments'))
            ->assertOk()
            ->assertDontSee('Electrical Assignment');

        $this->actingAs($fixture['studentUser'])
            ->get(route('student.materials.download', $otherMaterial))
            ->assertForbidden();
        $this->actingAs($fixture['studentUser'])
            ->post(route('student.assignments.submit', $otherAssignment), [
                'submission_text' => 'Unauthorized submission.',
            ])
            ->assertForbidden();
    }

    public function test_cascading_record_deletions_also_remove_private_uploads(): void
    {
        $fixture = $this->createAcademicFixture();
        Storage::put('study-materials/course.pdf', 'material');
        Storage::put('assignment-submissions/course.pdf', 'submission');

        StudyMaterial::create([
            'course_id' => $fixture['course']->id,
            'teacher_id' => $fixture['teacher']->id,
            'title' => 'Course File',
            'file_path' => 'study-materials/course.pdf',
        ]);
        $assignment = Assignment::create([
            'course_id' => $fixture['course']->id,
            'teacher_id' => $fixture['teacher']->id,
            'title' => 'Course Assignment',
            'description' => 'Cascade cleanup coverage.',
            'deadline' => now()->addDay(),
        ]);
        AssignmentSubmission::create([
            'assignment_id' => $assignment->id,
            'student_id' => $fixture['student']->id,
            'file_path' => 'assignment-submissions/course.pdf',
            'submitted_at' => now(),
        ]);

        $this->actingAs($fixture['adminUser'])
            ->delete(route('admin.courses.destroy', $fixture['course']))
            ->assertRedirect(route('admin.courses'));

        Storage::assertMissing('study-materials/course.pdf');
        Storage::assertMissing('assignment-submissions/course.pdf');
        $this->assertDatabaseMissing('courses', ['id' => $fixture['course']->id]);
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
        $adminUser = User::factory()->create(['role' => 'admin']);
        $teacherUser = User::factory()->create(['role' => 'teacher']);
        $studentUser = User::factory()->create(['role' => 'student']);

        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'teacher_id' => 'TCH-1001',
            'department' => 'Computer Science and Engineering',
            'designation' => 'Lecturer',
        ]);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_id' => 'STU-1001',
            'department' => 'Computer Science and Engineering',
            'semester' => '6th',
            'batch' => '2022',
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
