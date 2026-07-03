<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherNoticeController extends Controller
{
    public function index(): View
    {
        $notices = Notice::with('postedBy')
            ->whereIn('target_role', ['all', 'teacher'])
            ->orWhere('posted_by', auth()->id())
            ->latest()
            ->get();

        return view('teacher.notices', compact('notices'));
    }

    public function create(): View
    {
        return view('teacher.notices.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'target_role' => ['required', 'in:all,student,teacher'],
        ]);

        Notice::create([
            ...$validated,
            'posted_by' => $request->user()->id,
        ]);

        return redirect()
            ->route('teacher.notices')
            ->with('success', 'Notice posted successfully.');
    }
}
