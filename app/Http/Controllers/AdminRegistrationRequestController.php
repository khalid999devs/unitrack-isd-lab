<?php

namespace App\Http\Controllers;

use App\Models\RegistrationRequest;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminRegistrationRequestController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->input('status', 'pending');
        if (! in_array($status, ['pending', 'approved', 'rejected', 'all'], true)) {
            $status = 'pending';
        }

        $query = RegistrationRequest::with('reviewer')
            ->when($status !== 'all', fn ($registrationQuery) => $registrationQuery->where('status', $status));

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($searchQuery) use ($search) {
                $searchQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('student_id', 'like', "%{$search}%")
                    ->orWhere('teacher_id', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%");
            });
        }

        return view('admin.registration-requests.index', [
            'registrationRequests' => $query->latest()->paginate(10)->withQueryString(),
            'status' => $status,
            'counts' => [
                'pending' => RegistrationRequest::where('status', 'pending')->count(),
                'approved' => RegistrationRequest::where('status', 'approved')->count(),
                'rejected' => RegistrationRequest::where('status', 'rejected')->count(),
            ],
        ]);
    }

    public function approve(RegistrationRequest $registrationRequest): RedirectResponse
    {
        if ($registrationRequest->status !== 'pending') {
            return back()->withErrors(['registration' => 'Only pending requests can be approved.']);
        }

        if (User::where('email', $registrationRequest->email)->exists()) {
            return back()->withErrors(['registration' => 'A user with this email already exists.']);
        }

        if ($registrationRequest->role === 'student' && Student::where('student_id', $registrationRequest->student_id)->exists()) {
            return back()->withErrors(['registration' => 'A student profile with this ID already exists.']);
        }

        if ($registrationRequest->role === 'teacher' && Teacher::where('teacher_id', $registrationRequest->teacher_id)->exists()) {
            return back()->withErrors(['registration' => 'A teacher profile with this ID already exists.']);
        }

        DB::transaction(function () use ($registrationRequest) {
            $user = User::create([
                'name' => $registrationRequest->name,
                'email' => $registrationRequest->email,
                'password' => $registrationRequest->password,
                'role' => $registrationRequest->role,
            ]);

            if ($registrationRequest->role === 'student') {
                Student::create([
                    'user_id' => $user->id,
                    'student_id' => $registrationRequest->student_id,
                    'department' => $registrationRequest->department,
                    'semester' => $registrationRequest->semester,
                    'batch' => $registrationRequest->batch,
                    'phone' => $registrationRequest->phone,
                    'address' => $registrationRequest->address,
                ]);
            }

            if ($registrationRequest->role === 'teacher') {
                Teacher::create([
                    'user_id' => $user->id,
                    'teacher_id' => $registrationRequest->teacher_id,
                    'department' => $registrationRequest->department,
                    'designation' => $registrationRequest->designation,
                    'phone' => $registrationRequest->phone,
                ]);
            }

            $registrationRequest->update([
                'status' => 'approved',
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
                'rejection_reason' => null,
            ]);
        });

        return back()->with('success', 'Registration request approved and account created.');
    }

    public function reject(Request $request, RegistrationRequest $registrationRequest): RedirectResponse
    {
        if ($registrationRequest->status !== 'pending') {
            return back()->withErrors(['registration' => 'Only pending requests can be rejected.']);
        }

        $request->validate([
            'rejection_reason' => ['nullable', 'string', 'max:1000'],
            'status' => ['nullable', Rule::in(['rejected'])],
        ]);

        $registrationRequest->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'rejection_reason' => $request->input('rejection_reason'),
        ]);

        return back()->with('success', 'Registration request rejected.');
    }
}
