<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminNoticeController extends Controller
{
    public function index(): View
    {
        $notices = Notice::with('postedBy')
            ->latest()
            ->get();

        return view('admin.notices', compact('notices'));
    }

    public function create(): View
    {
        return view('admin.notices.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        Notice::create([
            ...$validated,
            'posted_by' => $request->user()->id,
        ]);

        return redirect()
            ->route('admin.notices')
            ->with('success', 'Notice posted successfully.');
    }

    public function edit(Notice $notice): View
    {
        return view('admin.notices.edit', compact('notice'));
    }

    public function update(Request $request, Notice $notice): RedirectResponse
    {
        $notice->update($request->validate($this->rules()));

        return redirect()
            ->route('admin.notices')
            ->with('success', 'Notice updated successfully.');
    }

    public function destroy(Notice $notice): RedirectResponse
    {
        $notice->delete();

        return redirect()
            ->route('admin.notices')
            ->with('success', 'Notice deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'target_role' => ['required', 'in:all,student,teacher,admin'],
        ];
    }
}
