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

class AdminAssignmentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Assignment::with(['course', 'teacher.user'])->withCount('submissions');

        if ($request->filled('search')) {
            $search = $request->string('search')->trim()->toString();
            $query->where(function ($assignmentQuery) use ($search) {
                $assignmentQuery->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('course', function ($courseQuery) use ($search) {
                        $courseQuery->where('course_code', 'like', "%{$search}%")
                            ->orWhere('course_title', 'like', "%{$search}%");
                    });
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

        return view('admin.assignments.index', [
            'assignments' => $query->orderBy('deadline')->paginate(10)->withQueryString(),
            'courses' => Course::orderBy('course_code')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.assignments.create', [
            'courses' => $this->availableCourses(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $course = Course::findOrFail($validated['course_id']);

        Assignment::create([
            ...$validated,
            'teacher_id' => $course->teacher_id,
        ]);

        return redirect()
            ->route('admin.assignments')
            ->with('success', 'Assignment created successfully.');
    }

    public function edit(Assignment $assignment): View
    {
        return view('admin.assignments.edit', [
            'assignment' => $assignment,
            'courses' => $this->availableCourses(),
        ]);
    }

    public function update(Request $request, Assignment $assignment): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $course = Course::findOrFail($validated['course_id']);

        $assignment->update([
            ...$validated,
            'teacher_id' => $course->teacher_id,
        ]);

        return redirect()
            ->route('admin.assignments')
            ->with('success', 'Assignment updated successfully.');
    }

    public function submissions(Assignment $assignment): View
    {
        $students = Student::with('user')
            ->where('department', $assignment->course->department)
            ->where('semester', $assignment->course->semester)
            ->orderBy('student_id')
            ->get();

        $submissions = $assignment->submissions()
            ->with('student.user')
            ->get()
            ->keyBy('student_id');

        return view('admin.assignments.submissions', compact('assignment', 'students', 'submissions'));
    }

    public function downloadSubmission(AssignmentSubmission $assignmentSubmission): StreamedResponse
    {
        abort_unless($assignmentSubmission->file_path && Storage::exists($assignmentSubmission->file_path), 404);

        $extension = pathinfo($assignmentSubmission->file_path, PATHINFO_EXTENSION);
        $name = Str::slug($assignmentSubmission->student->student_id.'-'.$assignmentSubmission->assignment->title);

        return Storage::download(
            $assignmentSubmission->file_path,
            $name.($extension ? ".{$extension}" : ''),
        );
    }

    public function destroy(Assignment $assignment): RedirectResponse
    {
        $this->deleteSubmissionFiles($assignment);
        $assignment->delete();

        return redirect()
            ->route('admin.assignments')
            ->with('success', 'Assignment deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(): array
    {
        return [
            'course_id' => [
                'required',
                Rule::exists('courses', 'id')->where(fn ($query) => $query->whereNotNull('teacher_id')),
            ],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'deadline' => ['required', 'date'],
        ];
    }

    private function availableCourses()
    {
        return Course::with('teacher.user')
            ->whereNotNull('teacher_id')
            ->orderBy('course_code')
            ->get();
    }

    private function deleteSubmissionFiles(Assignment $assignment): void
    {
        $paths = $assignment->submissions()
            ->whereNotNull('file_path')
            ->pluck('file_path')
            ->all();

        if ($paths !== []) {
            Storage::delete($paths);
        }
    }
}
