<?php

namespace App\Http\Controllers;

use App\Models\RegistrationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RegistrationRequestController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $role = $request->input('role');

        $request->validate([
            'role' => ['required', Rule::in(['student', 'teacher'])],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
                Rule::unique('registration_requests', 'email')->where('status', 'pending'),
            ],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'department' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'student_id' => [
                Rule::requiredIf($role === 'student'),
                'nullable',
                'string',
                'max:100',
                'unique:students,student_id',
                Rule::unique('registration_requests', 'student_id')->where('status', 'pending'),
            ],
            'semester' => [Rule::requiredIf($role === 'student'), 'nullable', 'string', 'max:50'],
            'batch' => [Rule::requiredIf($role === 'student'), 'nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:1000'],
            'teacher_id' => [
                Rule::requiredIf($role === 'teacher'),
                'nullable',
                'string',
                'max:100',
                'unique:teachers,teacher_id',
                Rule::unique('registration_requests', 'teacher_id')->where('status', 'pending'),
            ],
            'designation' => [Rule::requiredIf($role === 'teacher'), 'nullable', 'string', 'max:255'],
        ]);

        RegistrationRequest::create([
            'name' => $request->input('name'),
            'email' => strtolower($request->input('email')),
            'password' => $request->input('password'),
            'role' => $role,
            'student_id' => $role === 'student' ? $request->input('student_id') : null,
            'teacher_id' => $role === 'teacher' ? $request->input('teacher_id') : null,
            'department' => $request->input('department'),
            'semester' => $role === 'student' ? $request->input('semester') : null,
            'batch' => $role === 'student' ? $request->input('batch') : null,
            'designation' => $role === 'teacher' ? $request->input('designation') : null,
            'phone' => $request->filled('phone') ? $request->input('phone') : null,
            'address' => $role === 'student' && $request->filled('address') ? $request->input('address') : null,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Registration request submitted. You can sign in after admin approval.');
    }
}
