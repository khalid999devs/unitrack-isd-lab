<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\StudyMaterial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminMaterialController extends Controller
{
    public function index(Request $request): View
    {
        $query = StudyMaterial::with(['course', 'teacher.user']);

        if ($request->filled('search')) {
            $search = $request->string('search')->trim()->toString();
            $query->where(function ($materialQuery) use ($search) {
                $materialQuery->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('course', function ($courseQuery) use ($search) {
                        $courseQuery->where('course_code', 'like', "%{$search}%")
                            ->orWhere('course_title', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->integer('course_id'));
        }

        return view('admin.materials.index', [
            'materials' => $query->latest()->paginate(10)->withQueryString(),
            'courses' => Course::orderBy('course_code')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.materials.create', [
            'courses' => $this->availableCourses(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules(requireFile: true));
        $course = Course::findOrFail($validated['course_id']);

        StudyMaterial::create([
            'course_id' => $course->id,
            'teacher_id' => $course->teacher_id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'file_path' => $request->file('material_file')->store('study-materials'),
        ]);

        return redirect()
            ->route('admin.materials')
            ->with('success', 'Study material uploaded successfully.');
    }

    public function edit(StudyMaterial $studyMaterial): View
    {
        return view('admin.materials.edit', [
            'material' => $studyMaterial,
            'courses' => $this->availableCourses(),
        ]);
    }

    public function update(Request $request, StudyMaterial $studyMaterial): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $course = Course::findOrFail($validated['course_id']);
        $filePath = $studyMaterial->file_path;

        if ($request->hasFile('material_file')) {
            $newFilePath = $request->file('material_file')->store('study-materials');

            if ($filePath) {
                Storage::delete($filePath);
            }

            $filePath = $newFilePath;
        }

        $studyMaterial->update([
            'course_id' => $course->id,
            'teacher_id' => $course->teacher_id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'file_path' => $filePath,
        ]);

        return redirect()
            ->route('admin.materials')
            ->with('success', 'Study material updated successfully.');
    }

    public function download(StudyMaterial $studyMaterial): StreamedResponse
    {
        abort_unless($studyMaterial->file_path && Storage::exists($studyMaterial->file_path), 404);

        return Storage::download($studyMaterial->file_path, $this->downloadName($studyMaterial));
    }

    public function destroy(StudyMaterial $studyMaterial): RedirectResponse
    {
        if ($studyMaterial->file_path) {
            Storage::delete($studyMaterial->file_path);
        }

        $studyMaterial->delete();

        return redirect()
            ->route('admin.materials')
            ->with('success', 'Study material deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(bool $requireFile = false): array
    {
        return [
            'course_id' => [
                'required',
                Rule::exists('courses', 'id')->where(fn ($query) => $query->whereNotNull('teacher_id')),
            ],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'material_file' => [
                $requireFile ? 'required' : 'nullable',
                'file',
                'max:10240',
                'mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png',
            ],
        ];
    }

    private function availableCourses()
    {
        return Course::with('teacher.user')
            ->whereNotNull('teacher_id')
            ->orderBy('course_code')
            ->get();
    }

    private function downloadName(StudyMaterial $studyMaterial): string
    {
        $extension = pathinfo((string) $studyMaterial->file_path, PATHINFO_EXTENSION);

        return Str::slug($studyMaterial->title).($extension ? ".{$extension}" : '');
    }
}
