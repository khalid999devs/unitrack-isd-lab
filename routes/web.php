<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardPageController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::controller(DashboardPageController::class)->group(function () {
        Route::get('/dashboard', 'studentDashboard')->name('dashboard');
        Route::get('/courses', 'studentCourses')->name('courses');
        Route::get('/routine', 'studentRoutine')->name('routine');
        Route::get('/notices', 'studentNotices')->name('notices');
        Route::get('/materials', 'studentMaterials')->name('materials');
        Route::get('/assignments', 'studentAssignments')->name('assignments');
    });
});

Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::controller(DashboardPageController::class)->group(function () {
        Route::get('/dashboard', 'teacherDashboard')->name('dashboard');
        Route::get('/courses', 'teacherCourses')->name('courses');
        Route::get('/routine', 'teacherRoutine')->name('routine');
        Route::get('/materials', 'teacherMaterials')->name('materials');
        Route::get('/assignments', 'teacherAssignments')->name('assignments');
        Route::get('/notices', 'teacherNotices')->name('notices');
    });
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardPageController::class, 'adminDashboard'])->name('dashboard');

    Route::resource('students', StudentController::class)->names([
        'index' => 'students',
    ]);

    Route::resource('teachers', TeacherController::class)->names([
        'index' => 'teachers',
    ]);

    Route::resource('courses', CourseController::class)->names([
        'index' => 'courses',
    ]);

    Route::resource('routines', RoutineController::class)->names([
        'index' => 'routines',
    ]);

    Route::controller(DashboardPageController::class)->group(function () {
        Route::get('/notices', 'adminNotices')->name('notices');
    });
});
