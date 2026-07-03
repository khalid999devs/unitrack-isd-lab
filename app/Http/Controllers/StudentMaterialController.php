<?php

namespace App\Http\Controllers;

use App\Models\StudyMaterial;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StudentMaterialController extends Controller
{
    public function download(StudyMaterial $studyMaterial): StreamedResponse
    {
        $student = auth()->user()->student;

        abort_unless($student && $studyMaterial->course->semester === $student->semester, Response::HTTP_FORBIDDEN);

        $filename = Str::slug($studyMaterial->title).'.txt';

        return response()->streamDownload(function () use ($studyMaterial): void {
            echo "UniTrack Study Material\n";
            echo "Title: {$studyMaterial->title}\n";
            echo "Course: {$studyMaterial->course->course_code} - {$studyMaterial->course->course_title}\n";
            echo "Description: {$studyMaterial->description}\n";
            echo "Demo file path: {$studyMaterial->file_path}\n";
        }, $filename, ['Content-Type' => 'text/plain']);
    }
}
