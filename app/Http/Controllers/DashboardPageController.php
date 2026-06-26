<?php

namespace App\Http\Controllers;

use App\Models\Routine;

class DashboardPageController extends Controller
{
    public function studentCourses()
    {
        return view('student.courses');
    }

    public function studentRoutine()
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

    public function studentNotices()
    {
        return view('student.notices');
    }

    public function studentMaterials()
    {
        return view('student.materials');
    }

    public function studentAssignments()
    {
        return view('student.assignments');
    }

    public function teacherCourses()
    {
        return view('teacher.courses');
    }

    public function teacherRoutine()
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

    public function teacherMaterials()
    {
        return view('teacher.materials');
    }

    public function teacherAssignments()
    {
        return view('teacher.assignments');
    }

    public function teacherNotices()
    {
        return view('teacher.notices');
    }

    public function adminStudents()
    {
        return view('admin.students');
    }

    public function adminTeachers()
    {
        return view('admin.teachers');
    }

    public function adminCourses()
    {
        return view('admin.courses');
    }

    public function adminNotices()
    {
        return view('admin.notices');
    }
}
