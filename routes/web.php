<?php

use App\Http\Controllers\DashboardPageController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/student/dashboard', function () {
    return view('student.dashboard');
})->name('student.dashboard');

Route::get('/teacher/dashboard', function () {
    return view('teacher.dashboard');
})->name('teacher.dashboard');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::controller(DashboardPageController::class)->group(function () {
    Route::get('/student/courses', 'studentCourses')->name('student.courses');
    Route::get('/student/routine', 'studentRoutine')->name('student.routine');
    Route::get('/student/notices', 'studentNotices')->name('student.notices');
    Route::get('/student/materials', 'studentMaterials')->name('student.materials');
    Route::get('/student/assignments', 'studentAssignments')->name('student.assignments');

    Route::get('/teacher/courses', 'teacherCourses')->name('teacher.courses');
    Route::get('/teacher/routine', 'teacherRoutine')->name('teacher.routine');
    Route::get('/teacher/materials', 'teacherMaterials')->name('teacher.materials');
    Route::get('/teacher/assignments', 'teacherAssignments')->name('teacher.assignments');
    Route::get('/teacher/notices', 'teacherNotices')->name('teacher.notices');

    Route::get('/admin/students', 'adminStudents')->name('admin.students');
    Route::get('/admin/teachers', 'adminTeachers')->name('admin.teachers');
    Route::get('/admin/courses', 'adminCourses')->name('admin.courses');
    Route::get('/admin/routines', 'adminRoutines')->name('admin.routines');
    Route::get('/admin/notices', 'adminNotices')->name('admin.notices');
});
