<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\StudyMaterial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TeacherMaterialController extends Controller
{
    public function index(): View
    {
        $teacher = auth()->user()->teacher;
        $materials = $teacher
            ? $teacher->studyMaterials()->with('course')->latest()->get()
            : collect();

        return view('teacher.materials', compact('materials'));
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
            if ($filePath) {
                Storage::delete($filePath);
            }

            $filePath = $request->file('material_file')->store('study-materials');
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
            'description' => ['nullable', 'string'],
            'material_file' => [$requireFile ? 'required' : 'nullable', 'file', 'max:10240'],
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
