<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TeacherAssignmentController extends Controller
{
    public function index(Request $request): View
    {
        $teacher = auth()->user()->teacher;
        $query = $teacher
            ? $teacher->assignments()->with('course')->withCount('submissions')
            : Assignment::query()->whereRaw('1 = 0')->with('course')->withCount('submissions');

        if ($request->filled('search')) {
            $search = $request->string('search')->trim()->toString();
            $query->where(function ($assignmentQuery) use ($search) {
                $assignmentQuery->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->integer('course_id'));
        }

        match ($request->input('deadline')) {
            'upcoming' => $query->where('deadline', '>=', now()),
            'past' => $query->where('deadline', '<', now()),
            default => null,
        };

        $assignments = $query->orderBy('deadline')->paginate(8)->withQueryString();

        return view('teacher.assignments', [
            'assignments' => $assignments,
            'courses' => $this->teacherCourses(),
        ]);
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

    public function edit(Assignment $assignment): View
    {
        $this->authorizeTeacherAssignment($assignment);

        return view('teacher.assignments.edit', [
            'assignment' => $assignment,
            'courses' => $this->teacherCourses(),
        ]);
    }

    public function update(Request $request, Assignment $assignment): RedirectResponse
    {
        $this->authorizeTeacherAssignment($assignment);
        $assignment->update($request->validate($this->rules()));

        return redirect()
            ->route('teacher.assignments')
            ->with('success', 'Assignment updated successfully.');
    }

    public function submissions(Assignment $assignment): View
    {
        $this->authorizeTeacherAssignment($assignment);

        $students = Student::with('user')
            ->where('department', $assignment->course->department)
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

        $extension = pathinfo($assignmentSubmission->file_path, PATHINFO_EXTENSION);
        $name = Str::slug($assignmentSubmission->student->student_id.'-'.$assignment->title);

        return Storage::download(
            $assignmentSubmission->file_path,
            $name.($extension ? ".{$extension}" : ''),
        );
    }

    public function destroy(Assignment $assignment): RedirectResponse
    {
        $this->authorizeTeacherAssignment($assignment);

        $paths = $assignment->submissions()
            ->whereNotNull('file_path')
            ->pluck('file_path')
            ->all();

        if ($paths !== []) {
            Storage::delete($paths);
        }

        $assignment->delete();

        return redirect()
            ->route('teacher.assignments')
            ->with('success', 'Assignment deleted successfully.');
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
            'description' => ['required', 'string', 'max:5000'],
            'deadline' => ['required', 'date'],
        ];
    }

    private function teacherCourses()
    {
        $teacher = auth()->user()->teacher;

        return $teacher
            ? Course::where('teacher_id', $teacher->id)->orderBy('course_code')->get()
            : collect();
    }

    private function authorizeTeacherAssignment(Assignment $assignment): void
    {
        $teacher = auth()->user()->teacher;

        abort_unless($teacher && $assignment->teacher_id === $teacher->id, 403);
    }
}
