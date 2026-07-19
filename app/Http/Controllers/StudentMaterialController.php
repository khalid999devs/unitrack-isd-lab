<?php

namespace App\Http\Controllers;

use App\Models\StudyMaterial;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StudentMaterialController extends Controller
{
    public function download(StudyMaterial $studyMaterial): StreamedResponse
    {
        $student = auth()->user()->student;

        abort_unless(
            $student
                && $studyMaterial->course->semester === $student->semester
                && $studyMaterial->course->department === $student->department,
            Response::HTTP_FORBIDDEN,
        );
        abort_unless($studyMaterial->file_path && Storage::exists($studyMaterial->file_path), Response::HTTP_NOT_FOUND);

        $extension = pathinfo($studyMaterial->file_path, PATHINFO_EXTENSION);
        $name = Str::slug($studyMaterial->title).($extension ? ".{$extension}" : '');

        return Storage::download($studyMaterial->file_path, $name);
    }
}
