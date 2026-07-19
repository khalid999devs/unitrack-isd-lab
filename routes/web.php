<?php

use App\Http\Controllers\AdminAssignmentController;
use App\Http\Controllers\AdminMaterialController;
use App\Http\Controllers\AdminNoticeController;
use App\Http\Controllers\AdminRegistrationRequestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationRequestController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\StudentAssignmentSubmissionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentMaterialController;
use App\Http\Controllers\TeacherAssignmentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherMaterialController;
use App\Http\Controllers\TeacherNoticeController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:login')
        ->name('login.store');
    Route::get('/register', [RegistrationRequestController::class, 'create'])->name('register');
    Route::post('/register', [RegistrationRequestController::class, 'store'])
        ->middleware('throttle:registration')
        ->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'showStudent'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'updateStudent'])->name('profile.update');

    Route::controller(DashboardPageController::class)->group(function () {
        Route::get('/dashboard', 'studentDashboard')->name('dashboard');
        Route::get('/courses', 'studentCourses')->name('courses');
        Route::get('/routine', 'studentRoutine')->name('routine');
        Route::get('/notices', 'studentNotices')->name('notices');
        Route::get('/materials', 'studentMaterials')->name('materials');
        Route::get('/assignments', 'studentAssignments')->name('assignments');
    });

    Route::get('/materials/{studyMaterial}/download', [StudentMaterialController::class, 'download'])
        ->name('materials.download');

    Route::post('/assignments/{assignment}/submit', [StudentAssignmentSubmissionController::class, 'store'])
        ->name('assignments.submit');
});

Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'showTeacher'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'updateTeacher'])->name('profile.update');

    Route::controller(DashboardPageController::class)->group(function () {
        Route::get('/dashboard', 'teacherDashboard')->name('dashboard');
        Route::get('/courses', 'teacherCourses')->name('courses');
        Route::get('/routine', 'teacherRoutine')->name('routine');
    });

    Route::resource('materials', TeacherMaterialController::class)
        ->except(['show'])
        ->parameters(['materials' => 'studyMaterial'])
        ->names([
            'index' => 'materials',
        ]);

    Route::get('/materials/{studyMaterial}/download', [TeacherMaterialController::class, 'download'])
        ->name('materials.download');

    Route::get('/assignments/{assignment}/submissions', [TeacherAssignmentController::class, 'submissions'])
        ->name('assignments.submissions');
    Route::get('/assignment-submissions/{assignmentSubmission}/download', [TeacherAssignmentController::class, 'downloadSubmission'])
        ->name('assignments.submissions.download');

    Route::resource('assignments', TeacherAssignmentController::class)
        ->except(['show'])
        ->names([
            'index' => 'assignments',
        ]);

    Route::resource('notices', TeacherNoticeController::class)
        ->except(['show'])
        ->names([
            'index' => 'notices',
        ]);
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardPageController::class, 'adminDashboard'])->name('dashboard');

    Route::get('/registration-requests', [AdminRegistrationRequestController::class, 'index'])
        ->name('registration-requests');
    Route::post('/registration-requests/{registrationRequest}/approve', [AdminRegistrationRequestController::class, 'approve'])
        ->name('registration-requests.approve');
    Route::post('/registration-requests/{registrationRequest}/reject', [AdminRegistrationRequestController::class, 'reject'])
        ->name('registration-requests.reject');

    Route::resource('students', StudentController::class)
        ->except(['show'])
        ->names([
            'index' => 'students',
        ]);

    Route::resource('teachers', TeacherController::class)
        ->except(['show'])
        ->names([
            'index' => 'teachers',
        ]);

    Route::resource('courses', CourseController::class)
        ->except(['show'])
        ->names([
            'index' => 'courses',
        ]);

    Route::resource('routines', RoutineController::class)
        ->except(['show'])
        ->names([
            'index' => 'routines',
        ]);

    Route::resource('notices', AdminNoticeController::class)
        ->except(['show'])
        ->names([
            'index' => 'notices',
        ]);

    Route::get('/materials/{studyMaterial}/download', [AdminMaterialController::class, 'download'])
        ->name('materials.download');
    Route::resource('materials', AdminMaterialController::class)
        ->except(['show'])
        ->parameters(['materials' => 'studyMaterial'])
        ->names([
            'index' => 'materials',
        ]);

    Route::get('/assignments/{assignment}/submissions', [AdminAssignmentController::class, 'submissions'])
        ->name('assignments.submissions');
    Route::get('/assignment-submissions/{assignmentSubmission}/download', [AdminAssignmentController::class, 'downloadSubmission'])
        ->name('assignments.submissions.download');
    Route::resource('assignments', AdminAssignmentController::class)
        ->except(['show'])
        ->names([
            'index' => 'assignments',
        ]);
});
