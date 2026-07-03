<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentAssignmentSubmissionController extends Controller
{
    public function store(Request $request, Assignment $assignment): RedirectResponse
    {
        $student = $request->user()->student;

        abort_unless($student && $assignment->course->semester === $student->semester, 403);
        abort_if($assignment->deadline->isPast(), 403);

        $validated = $request->validate([
            'submission_text' => ['nullable', 'string'],
            'submission_file' => ['nullable', 'file', 'max:10240'],
        ]);

        if (! $request->filled('submission_text') && ! $request->hasFile('submission_file')) {
            return back()
                ->withErrors(['submission_text' => 'Write a submission note or attach a file.'])
                ->withInput();
        }

        $submission = AssignmentSubmission::firstOrNew([
            'assignment_id' => $assignment->id,
            'student_id' => $student->id,
        ]);

        $filePath = $submission->file_path;

        if ($request->hasFile('submission_file')) {
            if ($filePath) {
                Storage::delete($filePath);
            }

            $filePath = $request->file('submission_file')->store('assignment-submissions');
        }

        $submission->fill([
            'submission_text' => $validated['submission_text'] ?? null,
            'file_path' => $filePath,
            'submitted_at' => now(),
        ])->save();

        return redirect()
            ->route('student.assignments')
            ->with('success', 'Assignment submitted successfully.');
    }
}
