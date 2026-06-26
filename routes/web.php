<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardPageController;
use App\Http\Controllers\RoutineController;
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
    Route::get('/dashboard', function () {
        return view('student.dashboard');
    })->name('dashboard');

    Route::controller(DashboardPageController::class)->group(function () {
        Route::get('/courses', 'studentCourses')->name('courses');
        Route::get('/routine', 'studentRoutine')->name('routine');
        Route::get('/notices', 'studentNotices')->name('notices');
        Route::get('/materials', 'studentMaterials')->name('materials');
        Route::get('/assignments', 'studentAssignments')->name('assignments');
    });
});

Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', function () {
        return view('teacher.dashboard');
    })->name('dashboard');

    Route::controller(DashboardPageController::class)->group(function () {
        Route::get('/courses', 'teacherCourses')->name('courses');
        Route::get('/routine', 'teacherRoutine')->name('routine');
        Route::get('/materials', 'teacherMaterials')->name('materials');
        Route::get('/assignments', 'teacherAssignments')->name('assignments');
        Route::get('/notices', 'teacherNotices')->name('notices');
    });
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('routines', RoutineController::class)->names([
        'index' => 'routines',
    ]);

    Route::controller(DashboardPageController::class)->group(function () {
        Route::get('/students', 'adminStudents')->name('students');
        Route::get('/teachers', 'adminTeachers')->name('teachers');
        Route::get('/courses', 'adminCourses')->name('courses');
        Route::get('/notices', 'adminNotices')->name('notices');
    });
});
