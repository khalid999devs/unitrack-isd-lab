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
use Illuminate\View\View;

class DashboardPageController extends Controller
{
    public function studentDashboard(): View
    {
        $student = auth()->user()->student;
        $courseIds = $student
            ? Course::where('semester', $student->semester)->pluck('id')
            : collect();

        return view('student.dashboard', [
            'courseCount' => $courseIds->count(),
            'todayClassCount' => $student
                ? Routine::where('semester', $student->semester)
                    ->where('batch', $student->batch)
                    ->where('day', now()->format('l'))
                    ->count()
                : 0,
            'noticeCount' => Notice::whereIn('target_role', ['all', 'student'])->count(),
            'assignmentCount' => $courseIds->isNotEmpty()
                ? Assignment::whereIn('course_id', $courseIds)
                    ->where('deadline', '>=', now())
                    ->count()
                : 0,
        ]);
    }

    public function studentCourses(Request $request): View
    {
        $student = auth()->user()->student;
        $courses = collect();

        if ($student) {
            $query = Course::with('teacher.user')
                ->where('semester', $student->semester);

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
                ->orderByRaw($dayOrder)
                ->orderBy('start_time')
                ->get();
        }

        return view('student.routine', compact('routines'));
    }

    public function studentNotices(): View
    {
        $notices = Notice::with('postedBy')
            ->whereIn('target_role', ['all', 'student'])
            ->latest()
            ->get();

        return view('student.notices', compact('notices'));
    }

    public function studentMaterials(): View
    {
        $student = auth()->user()->student;
        $courseIds = $student
            ? Course::where('semester', $student->semester)->pluck('id')
            : collect();

        $materials = StudyMaterial::with(['course', 'teacher.user'])
            ->whereIn('course_id', $courseIds)
            ->latest()
            ->get();

        return view('student.materials', compact('materials'));
    }

    public function studentAssignments(): View
    {
        $student = auth()->user()->student;
        $courseIds = $student
            ? Course::where('semester', $student->semester)->pluck('id')
            : collect();

        $assignments = Assignment::with([
            'course',
            'submissions' => fn ($query) => $student
                ? $query->where('student_id', $student->id)
                : $query->whereRaw('1 = 0'),
        ])
            ->whereIn('course_id', $courseIds)
            ->orderBy('deadline')
            ->get();

        return view('student.assignments', compact('assignments'));
    }

    public function teacherDashboard(): View
    {
        $teacher = auth()->user()->teacher;

        return view('teacher.dashboard', [
            'courseCount' => $teacher ? $teacher->courses()->count() : 0,
            'todayClassCount' => $teacher
                ? $teacher->routines()
                    ->where('day', now()->format('l'))
                    ->count()
                : 0,
            'materialCount' => $teacher ? $teacher->studyMaterials()->count() : 0,
            'assignmentCount' => $teacher
                ? $teacher->assignments()
                    ->where('deadline', '>=', now())
                    ->count()
                : 0,
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
}
