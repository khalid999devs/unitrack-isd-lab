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

        abort_unless(
            $student
                && $assignment->course->semester === $student->semester
                && $assignment->course->department === $student->department,
            403,
        );
        abort_if($assignment->deadline->isPast(), 403);

        $validated = $request->validate([
            'submission_text' => ['nullable', 'string', 'max:5000'],
            'submission_file' => [
                'nullable',
                'file',
                'max:10240',
                'mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,zip',
            ],
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
            $newFilePath = $request->file('submission_file')->store('assignment-submissions');

            if ($filePath) {
                Storage::delete($filePath);
            }

            $filePath = $newFilePath;
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
