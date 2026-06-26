<?php

namespace App\Http\Controllers;

class DashboardPageController extends Controller
{
    public function studentCourses()
    {
        return view('student.courses');
    }

    public function studentRoutine()
    {
        return view('student.routine');
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
        return view('teacher.routine');
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

    public function adminCourses()
    {
        return view('admin.courses');
    }

    public function adminRoutines()
    {
        return view('admin.routines');
    }

    public function adminNotices()
    {
        return view('admin.notices');
    }
}
