<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Course;
use App\Models\Notice;
use App\Models\RegistrationRequest;
use App\Models\Routine;
use App\Models\Student;
use App\Models\StudyMaterial;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class DashboardPageController extends Controller
{
    public function studentDashboard(): View
    {
        $student = auth()->user()->student;
        $courseIds = $this->studentCourseIds($student);

        $todayRoutines = $student
            ? Routine::with(['course', 'teacher.user'])
                ->where('semester', $student->semester)
                ->where('batch', $student->batch)
                ->where('day', now()->format('l'))
                ->whereHas('course', fn ($query) => $query->where('department', $student->department))
                ->orderBy('start_time')
                ->limit(3)
                ->get()
            : collect();

        $latestNotices = Notice::with('postedBy')
            ->whereIn('target_role', ['all', 'student'])
            ->latest()
            ->limit(3)
            ->get();

        $recentMaterials = StudyMaterial::with(['course', 'teacher.user'])
            ->whereIn('course_id', $courseIds)
            ->latest()
            ->limit(3)
            ->get();

        $upcomingAssignments = Assignment::with('course')
            ->whereIn('course_id', $courseIds)
            ->where('deadline', '>=', now())
            ->orderBy('deadline')
            ->limit(3)
            ->get();

        return view('student.dashboard', [
            'courseCount' => $courseIds->count(),
            'todayClassCount' => $todayRoutines->count(),
            'noticeCount' => Notice::whereIn('target_role', ['all', 'student'])->count(),
            'assignmentCount' => $courseIds->isNotEmpty()
                ? Assignment::whereIn('course_id', $courseIds)
                    ->where('deadline', '>=', now())
                    ->count()
                : 0,
            'todayRoutines' => $todayRoutines,
            'latestNotices' => $latestNotices,
            'recentMaterials' => $recentMaterials,
            'upcomingAssignments' => $upcomingAssignments,
        ]);
    }

    public function studentCourses(Request $request): View
    {
        $student = auth()->user()->student;
        $courses = collect();

        if ($student) {
            $query = Course::with('teacher.user')
                ->where('semester', $student->semester)
                ->where('department', $student->department);

            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('course_code', 'like', "%{$search}%")
                        ->orWhere('course_title', 'like', "%{$search}%")
                        ->orWhereHas('teacher.user', function ($teacherQuery) use ($search) {
                            $teacherQuery->where('name', 'like', "%{$search}%");
                        });
                });
            }

            $courses = $query->orderBy('course_code')->get();
        }

        return view('student.courses', compact('courses', 'student'));
    }

    public function studentRoutine(): View
    {
        $student = auth()->user()->student;
        $routines = collect();

        if ($student) {
            $dayOrder = "CASE day
                WHEN 'Sunday' THEN 1
                WHEN 'Monday' THEN 2
                WHEN 'Tuesday' THEN 3
                WHEN 'Wednesday' THEN 4
                WHEN 'Thursday' THEN 5
                WHEN 'Friday' THEN 6
                WHEN 'Saturday' THEN 7
                ELSE 8
            END";

            $routines = Routine::with(['course', 'teacher.user'])
                ->where('semester', $student->semester)
                ->where('batch', $student->batch)
                ->whereHas('course', fn ($query) => $query->where('department', $student->department))
                ->orderByRaw($dayOrder)
                ->orderBy('start_time')
                ->get();
        }

        return view('student.routine', compact('routines'));
    }

    public function studentNotices(Request $request): View
    {
        $query = Notice::with('postedBy')
            ->whereIn('target_role', ['all', 'student']);

        if ($request->filled('search')) {
            $search = $request->string('search')->trim()->toString();
            $query->where(function ($noticeQuery) use ($search) {
                $noticeQuery->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $notices = $query->latest()->paginate(8)->withQueryString();

        return view('student.notices', compact('notices'));
    }

    public function studentMaterials(Request $request): View
    {
        $student = auth()->user()->student;
        $courseIds = $this->studentCourseIds($student);

        $query = StudyMaterial::with(['course', 'teacher.user'])
            ->whereIn('course_id', $courseIds);

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->integer('course_id'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->trim()->toString();
            $query->where(function ($materialQuery) use ($search) {
                $materialQuery->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $materials = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $courses = Course::whereIn('id', $courseIds)
            ->orderBy('course_code')
            ->get();

        return view('student.materials', compact('materials', 'courses'));
    }

    public function studentAssignments(Request $request): View
    {
        $student = auth()->user()->student;
        $courseIds = $this->studentCourseIds($student);

        $query = Assignment::with([
            'course',
            'submissions' => fn ($query) => $student
                ? $query->where('student_id', $student->id)
                : $query->whereRaw('1 = 0'),
        ])
            ->whereIn('course_id', $courseIds);

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->integer('course_id'));
        }

        match ($request->input('deadline')) {
            'upcoming' => $query->where('deadline', '>=', now()),
            'past' => $query->where('deadline', '<', now()),
            'submitted' => $student
                ? $query->whereHas('submissions', fn ($submissionQuery) => $submissionQuery->where('student_id', $student->id))
                : $query->whereRaw('1 = 0'),
            default => null,
        };

        $assignments = $query
            ->orderBy('deadline')
            ->paginate(8)
            ->withQueryString();

        $courses = Course::whereIn('id', $courseIds)
            ->orderBy('course_code')
            ->get();

        return view('student.assignments', compact('assignments', 'courses'));
    }

    public function teacherDashboard(): View
    {
        $teacher = auth()->user()->teacher;

        $todayRoutines = $teacher
            ? $teacher->routines()
                ->with('course')
                ->where('day', now()->format('l'))
                ->orderBy('start_time')
                ->limit(3)
                ->get()
            : collect();

        $recentMaterials = $teacher
            ? $teacher->studyMaterials()->with('course')->latest()->limit(3)->get()
            : collect();

        $upcomingAssignments = $teacher
            ? $teacher->assignments()
                ->with('course')
                ->where('deadline', '>=', now())
                ->orderBy('deadline')
                ->limit(3)
                ->get()
            : collect();

        $latestNotices = Notice::with('postedBy')
            ->where(function ($query) {
                $query->whereIn('target_role', ['all', 'teacher'])
                    ->orWhere('posted_by', auth()->id());
            })
            ->latest()
            ->limit(3)
            ->get();

        return view('teacher.dashboard', [
            'courseCount' => $teacher ? $teacher->courses()->count() : 0,
            'todayClassCount' => $todayRoutines->count(),
            'materialCount' => $teacher ? $teacher->studyMaterials()->count() : 0,
            'assignmentCount' => $teacher
                ? $teacher->assignments()
                    ->where('deadline', '>=', now())
                    ->count()
                : 0,
            'noticeCount' => Notice::where('posted_by', auth()->id())->count(),
            'todayRoutines' => $todayRoutines,
            'recentMaterials' => $recentMaterials,
            'upcomingAssignments' => $upcomingAssignments,
            'latestNotices' => $latestNotices,
        ]);
    }

    public function teacherCourses(Request $request): View
    {
        $teacher = auth()->user()->teacher;
        $courses = collect();

        if ($teacher) {
            $query = Course::where('teacher_id', $teacher->id);

            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('course_code', 'like', "%{$search}%")
                        ->orWhere('course_title', 'like', "%{$search}%")
                        ->orWhere('semester', 'like', "%{$search}%");
                });
            }

            $courses = $query->orderBy('course_code')->get();
        }

        return view('teacher.courses', compact('courses', 'teacher'));
    }

    public function teacherRoutine(): View
    {
        $teacher = auth()->user()->teacher;
        $routines = collect();

        if ($teacher) {
            $dayOrder = "CASE day
                WHEN 'Sunday' THEN 1
                WHEN 'Monday' THEN 2
                WHEN 'Tuesday' THEN 3
                WHEN 'Wednesday' THEN 4
                WHEN 'Thursday' THEN 5
                WHEN 'Friday' THEN 6
                WHEN 'Saturday' THEN 7
                ELSE 8
            END";

            $routines = Routine::with(['course', 'teacher.user'])
                ->where('teacher_id', $teacher->id)
                ->orderByRaw($dayOrder)
                ->orderBy('start_time')
                ->get();
        }

        return view('teacher.routine', compact('routines'));
    }

    public function adminDashboard(): View
    {
        return view('admin.dashboard', [
            'studentCount' => Student::count(),
            'teacherCount' => Teacher::count(),
            'courseCount' => Course::count(),
            'routineCount' => Routine::count(),
            'noticeCount' => Notice::count(),
            'materialCount' => StudyMaterial::count(),
            'assignmentCount' => Assignment::count(),
            'submissionCount' => AssignmentSubmission::count(),
            'pendingRegistrationCount' => RegistrationRequest::where('status', 'pending')->count(),
        ]);
    }

    private function studentCourseIds(?Student $student): Collection
    {
        if ($student === null) {
            return collect();
        }

        return Course::where('department', $student->department)
            ->where('semester', $student->semester)
            ->pluck('id');
    }
}
