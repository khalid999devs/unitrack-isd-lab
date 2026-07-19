<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function showStudent(Request $request): View
    {
        $student = $request->user()->student;

        abort_unless($student, 404);

        $student->load('user');

        return view('student.profile', compact('student'));
    }

    public function updateStudent(Request $request): RedirectResponse
    {
        $student = $request->user()->student;

        abort_unless($student, 404);

        $request->merge([
            'email' => Str::lower(trim((string) $request->input('email'))),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($request->user()->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($request, $student, $validated) {
            $request->user()->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $student->update([
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
            ]);
        });

        return back()->with('success', 'Profile updated successfully.');
    }

    public function showTeacher(Request $request): View
    {
        $teacher = $request->user()->teacher;

        abort_unless($teacher, 404);

        $teacher->load('user');

        return view('teacher.profile', compact('teacher'));
    }

    public function updateTeacher(Request $request): RedirectResponse
    {
        $teacher = $request->user()->teacher;

        abort_unless($teacher, 404);

        $request->merge([
            'email' => Str::lower(trim((string) $request->input('email'))),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($request->user()->id)],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        DB::transaction(function () use ($request, $teacher, $validated) {
            $request->user()->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $teacher->update([
                'phone' => $validated['phone'] ?? null,
            ]);
        });

        return back()->with('success', 'Profile updated successfully.');
    }
}
