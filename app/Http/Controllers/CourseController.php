<?php

namespace App\Http\Controllers;

use App\Models\AssignmentSubmission;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(Request $request): View
    {
        $query = Course::with('teacher.user');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('course_code', 'like', "%{$search}%")
                    ->orWhere('course_title', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department')) {
            $query->where('department', $request->input('department'));
        }

        if ($request->filled('semester')) {
            $query->where('semester', $request->input('semester'));
        }

        $courses = $query->latest()->paginate(10)->withQueryString();

        return view('admin.courses.index', [
            'courses' => $courses,
            'departments' => Course::query()->select('department')->distinct()->orderBy('department')->pluck('department'),
            'semesters' => Course::query()->select('semester')->distinct()->orderBy('semester')->pluck('semester'),
        ]);
    }

    public function create(): View
    {
        $teachers = Teacher::with('user')->get();

        return view('admin.courses.create', compact('teachers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'course_code' => ['required', 'string', 'max:50', 'unique:courses,course_code'],
            'course_title' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'semester' => ['required', 'string', 'max:50'],
            'credit' => ['required', 'numeric', 'min:0.5', 'max:10.0'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
        ]);

        Course::create($request->only([
            'course_code',
            'course_title',
            'department',
            'semester',
            'credit',
            'teacher_id',
        ]));

        return redirect()->route('admin.courses')
            ->with('success', 'Course created successfully.');
    }

    public function edit(Course $course): View
    {
        $teachers = Teacher::with('user')->get();

        return view('admin.courses.edit', compact('course', 'teachers'));
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $request->validate([
            'course_code' => ['required', 'string', 'max:50', 'unique:courses,course_code,'.$course->id],
            'course_title' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'semester' => ['required', 'string', 'max:50'],
            'credit' => ['required', 'numeric', 'min:0.5', 'max:10.0'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
        ]);

        $course->update($request->only([
            'course_code',
            'course_title',
            'department',
            'semester',
            'credit',
            'teacher_id',
        ]));

        return redirect()->route('admin.courses')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $materialPaths = $course->studyMaterials()
            ->whereNotNull('file_path')
            ->pluck('file_path')
            ->all();
        $submissionPaths = AssignmentSubmission::whereHas(
            'assignment',
            fn ($query) => $query->where('course_id', $course->id),
        )
            ->whereNotNull('file_path')
            ->pluck('file_path')
            ->all();

        $course->delete();
        Storage::delete([...$materialPaths, ...$submissionPaths]);

        return redirect()->route('admin.courses')
            ->with('success', 'Course deleted successfully.');
    }
}
