<?php

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
