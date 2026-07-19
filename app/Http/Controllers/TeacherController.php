<?php

namespace App\Http\Controllers;

use App\Models\AssignmentSubmission;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TeacherController extends Controller
{
    public function index(Request $request): View
    {
        $query = Teacher::with('user');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('teacher_id', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $teachers = $query->latest()->paginate(10)->withQueryString();

        return view('admin.teachers.index', compact('teachers'));
    }

    public function create(): View
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'email' => Str::lower(trim((string) $request->input('email'))),
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'teacher_id' => ['required', 'string', 'unique:teachers,teacher_id'],
            'department' => ['required', 'string', 'max:255'],
            'designation' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => 'teacher',
            ]);

            Teacher::create([
                'user_id' => $user->id,
                'teacher_id' => $request->teacher_id,
                'department' => $request->department,
                'designation' => $request->designation,
                'phone' => $request->phone,
            ]);
        });

        return redirect()->route('admin.teachers')
            ->with('success', 'Teacher created successfully.');
    }

    public function edit(Teacher $teacher): View
    {
        $teacher->load('user');

        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher): RedirectResponse
    {
        $request->merge([
            'email' => Str::lower(trim((string) $request->input('email'))),
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$teacher->user_id],
            'password' => ['nullable', 'string', 'min:6'],
            'teacher_id' => ['required', 'string', 'unique:teachers,teacher_id,'.$teacher->id],
            'department' => ['required', 'string', 'max:255'],
            'designation' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        DB::transaction(function () use ($request, $teacher) {
            $user = $teacher->user;
            $userUpdate = [
                'name' => $request->name,
                'email' => $request->email,
            ];
            if ($request->filled('password')) {
                $userUpdate['password'] = $request->password;
            }
            $user->update($userUpdate);

            $teacher->update([
                'teacher_id' => $request->teacher_id,
                'department' => $request->department,
                'designation' => $request->designation,
                'phone' => $request->phone,
            ]);
        });

        return redirect()->route('admin.teachers')
            ->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher): RedirectResponse
    {
        $materialPaths = $teacher->studyMaterials()
            ->whereNotNull('file_path')
            ->pluck('file_path')
            ->all();
        $submissionPaths = AssignmentSubmission::whereHas(
            'assignment',
            fn ($query) => $query->where('teacher_id', $teacher->id),
        )
            ->whereNotNull('file_path')
            ->pluck('file_path')
            ->all();

        $teacher->user->delete();
        Storage::delete([...$materialPaths, ...$submissionPaths]);

        return redirect()->route('admin.teachers')
            ->with('success', 'Teacher deleted successfully.');
    }
}
