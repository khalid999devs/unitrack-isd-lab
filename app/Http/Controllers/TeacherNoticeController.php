<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherNoticeController extends Controller
{
    public function index(Request $request): View
    {
        $query = Notice::with('postedBy')
            ->where(function ($noticeQuery) {
                $noticeQuery->whereIn('target_role', ['all', 'teacher'])
                    ->orWhere('posted_by', auth()->id());
            });

        if ($request->filled('search')) {
            $search = $request->string('search')->trim()->toString();
            $query->where(function ($searchQuery) use ($search) {
                $searchQuery->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $notices = $query->latest()->paginate(8)->withQueryString();

        return view('teacher.notices', compact('notices'));
    }

    public function create(): View
    {
        return view('teacher.notices.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        Notice::create([
            ...$validated,
            'posted_by' => $request->user()->id,
        ]);

        return redirect()
            ->route('teacher.notices')
            ->with('success', 'Notice posted successfully.');
    }

    public function edit(Notice $notice): View
    {
        $this->authorizeTeacherNotice($notice);

        return view('teacher.notices.edit', compact('notice'));
    }

    public function update(Request $request, Notice $notice): RedirectResponse
    {
        $this->authorizeTeacherNotice($notice);
        $notice->update($request->validate($this->rules()));

        return redirect()
            ->route('teacher.notices')
            ->with('success', 'Notice updated successfully.');
    }

    public function destroy(Notice $notice): RedirectResponse
    {
        $this->authorizeTeacherNotice($notice);
        $notice->delete();

        return redirect()
            ->route('teacher.notices')
            ->with('success', 'Notice deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'target_role' => ['required', 'in:all,student,teacher'],
        ];
    }

    private function authorizeTeacherNotice(Notice $notice): void
    {
        abort_unless($notice->posted_by === auth()->id(), 403);
    }
}
