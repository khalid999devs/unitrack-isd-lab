<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Student::with('user');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('student_id', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $students = $query->latest()->paginate(10)->withQueryString();

        return view('admin.students.index', compact('students'));
    }

    public function create(): View
    {
        return view('admin.students.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'student_id' => ['required', 'string', 'unique:students,student_id'],
            'department' => ['required', 'string', 'max:255'],
            'semester' => ['required', 'string', 'max:50'],
            'batch' => ['required', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => 'student',
            ]);

            Student::create([
                'user_id' => $user->id,
                'student_id' => $request->student_id,
                'department' => $request->department,
                'semester' => $request->semester,
                'batch' => $request->batch,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
        });

        return redirect()->route('admin.students')
            ->with('success', 'Student created successfully.');
    }

    public function edit(Student $student): View
    {
        $student->load('user');

        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$student->user_id],
            'password' => ['nullable', 'string', 'min:6'],
            'student_id' => ['required', 'string', 'unique:students,student_id,'.$student->id],
            'department' => ['required', 'string', 'max:255'],
            'semester' => ['required', 'string', 'max:50'],
            'batch' => ['required', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($request, $student) {
            $user = $student->user;
            $userUpdate = [
                'name' => $request->name,
                'email' => $request->email,
            ];
            if ($request->filled('password')) {
                $userUpdate['password'] = $request->password;
            }
            $user->update($userUpdate);

            $student->update([
                'student_id' => $request->student_id,
                'department' => $request->department,
                'semester' => $request->semester,
                'batch' => $request->batch,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
        });

        return redirect()->route('admin.students')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        // Cascades to delete student profile automatically
        $student->user->delete();

        return redirect()->route('admin.students')
            ->with('success', 'Student deleted successfully.');
    }
}
