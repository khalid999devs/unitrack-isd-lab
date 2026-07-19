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

class TeacherMaterialController extends Controller
{
    public function index(Request $request): View
    {
        $teacher = auth()->user()->teacher;
        $query = $teacher
            ? $teacher->studyMaterials()->with('course')
            : StudyMaterial::query()->whereRaw('1 = 0');

        if ($request->filled('search')) {
            $search = $request->string('search')->trim()->toString();
            $query->where(function ($materialQuery) use ($search) {
                $materialQuery->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->integer('course_id'));
        }

        $materials = $query->latest()->paginate(10)->withQueryString();

        return view('teacher.materials', [
            'materials' => $materials,
            'courses' => $this->teacherCourses(),
        ]);
    }

    public function create(): View
    {
        $courses = $this->teacherCourses();

        return view('teacher.materials.create', compact('courses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $teacher = auth()->user()->teacher;

        abort_unless($teacher, 403);

        $validated = $request->validate($this->rules(requireFile: true));

        StudyMaterial::create([
            'course_id' => $validated['course_id'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'file_path' => $request->file('material_file')->store('study-materials'),
            'teacher_id' => $teacher->id,
        ]);

        return redirect()
            ->route('teacher.materials')
            ->with('success', 'Study material uploaded successfully.');
    }

    public function edit(StudyMaterial $studyMaterial): View
    {
        $this->authorizeTeacherMaterial($studyMaterial);

        return view('teacher.materials.edit', [
            'material' => $studyMaterial,
            'courses' => $this->teacherCourses(),
        ]);
    }

    public function update(Request $request, StudyMaterial $studyMaterial): RedirectResponse
    {
        $this->authorizeTeacherMaterial($studyMaterial);

        $validated = $request->validate($this->rules());
        $filePath = $studyMaterial->file_path;

        if ($request->hasFile('material_file')) {
            $newFilePath = $request->file('material_file')->store('study-materials');

            if ($filePath) {
                Storage::delete($filePath);
            }

            $filePath = $newFilePath;
        }

        $studyMaterial->update([
            'course_id' => $validated['course_id'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'file_path' => $filePath,
        ]);

        return redirect()
            ->route('teacher.materials')
            ->with('success', 'Study material updated successfully.');
    }

    public function download(StudyMaterial $studyMaterial): StreamedResponse
    {
        $this->authorizeTeacherMaterial($studyMaterial);
        abort_unless($studyMaterial->file_path && Storage::exists($studyMaterial->file_path), 404);

        $extension = pathinfo($studyMaterial->file_path, PATHINFO_EXTENSION);
        $name = Str::slug($studyMaterial->title).($extension ? ".{$extension}" : '');

        return Storage::download($studyMaterial->file_path, $name);
    }

    public function destroy(StudyMaterial $studyMaterial): RedirectResponse
    {
        $this->authorizeTeacherMaterial($studyMaterial);

        if ($studyMaterial->file_path) {
            Storage::delete($studyMaterial->file_path);
        }

        $studyMaterial->delete();

        return redirect()
            ->route('teacher.materials')
            ->with('success', 'Study material deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(bool $requireFile = false): array
    {
        $teacher = auth()->user()->teacher;

        return [
            'course_id' => [
                'required',
                Rule::exists('courses', 'id')->where(fn ($query) => $query->where('teacher_id', $teacher?->id)),
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

    private function teacherCourses()
    {
        $teacher = auth()->user()->teacher;

        return $teacher
            ? Course::where('teacher_id', $teacher->id)->orderBy('course_code')->get()
            : collect();
    }

    private function authorizeTeacherMaterial(StudyMaterial $studyMaterial): void
    {
        $teacher = auth()->user()->teacher;

        abort_unless($teacher && $studyMaterial->teacher_id === $teacher->id, 403);
    }
}
