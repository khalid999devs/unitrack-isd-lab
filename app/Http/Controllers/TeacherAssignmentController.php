<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TeacherAssignmentController extends Controller
{
    public function index(): View
    {
        $teacher = auth()->user()->teacher;
        $assignments = $teacher
            ? $teacher->assignments()->with('course')->latest('deadline')->get()
            : collect();

        return view('teacher.assignments', compact('assignments'));
    }

    public function create(): View
    {
        $courses = $this->teacherCourses();

        return view('teacher.assignments.create', compact('courses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $teacher = auth()->user()->teacher;

        abort_unless($teacher, 403);

        Assignment::create([
            ...$request->validate($this->rules()),
            'teacher_id' => $teacher->id,
        ]);

        return redirect()
            ->route('teacher.assignments')
            ->with('success', 'Assignment created successfully.');
    }

    public function submissions(Assignment $assignment): View
    {
        $teacher = auth()->user()->teacher;

        abort_unless($teacher && $assignment->teacher_id === $teacher->id, 403);

        $students = Student::with('user')
            ->where('semester', $assignment->course->semester)
            ->orderBy('student_id')
            ->get();

        $submissions = $assignment->submissions()
            ->with('student.user')
            ->get()
            ->keyBy('student_id');

        return view('teacher.assignments.submissions', compact('assignment', 'students', 'submissions'));
    }

    public function downloadSubmission(AssignmentSubmission $assignmentSubmission): StreamedResponse
    {
        $teacher = auth()->user()->teacher;
        $assignment = $assignmentSubmission->assignment;

        abort_unless($teacher && $assignment->teacher_id === $teacher->id, 403);
        abort_unless($assignmentSubmission->file_path && Storage::exists($assignmentSubmission->file_path), 404);

        return Storage::download($assignmentSubmission->file_path);
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(): array
    {
        $teacher = auth()->user()->teacher;

        return [
            'course_id' => [
                'required',
                Rule::exists('courses', 'id')->where(fn ($query) => $query->where('teacher_id', $teacher?->id)),
            ],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'deadline' => ['required', 'date', 'after_or_equal:today'],
        ];
    }

    private function teacherCourses()
    {
        $teacher = auth()->user()->teacher;

        return $teacher
            ? Course::where('teacher_id', $teacher->id)->orderBy('course_code')->get()
            : collect();
    }
}
