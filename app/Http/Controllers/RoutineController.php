<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Routine;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoutineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Routine::with(['course', 'teacher.user']);

        if ($request->filled('semester')) {
            $query->where('semester', $request->input('semester'));
        }

        if ($request->filled('batch')) {
            $query->where('batch', $request->input('batch'));
        }

        if ($request->filled('day')) {
            $query->where('day', $request->input('day'));
        }

        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->integer('teacher_id'));
        }

        $dayOrder = "CASE day
            WHEN 'Sunday' THEN 1
            WHEN 'Monday' THEN 2
            WHEN 'Tuesday' THEN 3
            WHEN 'Wednesday' THEN 4
            WHEN 'Thursday' THEN 5
            WHEN 'Friday' THEN 6
            WHEN 'Saturday' THEN 7
            ELSE 8
        END";

        $routines = $query->orderByRaw($dayOrder)
            ->orderBy('start_time')
            ->paginate(10)
            ->withQueryString();

        return view('admin.routines.index', [
            'routines' => $routines,
            'teachers' => Teacher::with('user')->orderBy('teacher_id')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $courses = Course::orderBy('course_code')->get();
        $teachers = Teacher::with('user')->get();

        return view('admin.routines.create', compact('courses', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'semester' => ['required', 'string', 'max:50'],
            'batch' => ['required', 'string', 'max:50'],
            'day' => ['required', 'string', 'in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'room' => ['required', 'string', 'max:100'],
        ]);

        Routine::create($validated);

        return redirect()->route('admin.routines')
            ->with('success', 'Routine created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Routine $routine): View
    {
        $courses = Course::orderBy('course_code')->get();
        $teachers = Teacher::with('user')->get();

        $routine->start_time = date('H:i', strtotime($routine->start_time));
        $routine->end_time = date('H:i', strtotime($routine->end_time));

        return view('admin.routines.edit', compact('routine', 'courses', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Routine $routine): RedirectResponse
    {
        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'semester' => ['required', 'string', 'max:50'],
            'batch' => ['required', 'string', 'max:50'],
            'day' => ['required', 'string', 'in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'room' => ['required', 'string', 'max:100'],
        ]);

        $routine->update($validated);

        return redirect()->route('admin.routines')
            ->with('success', 'Routine updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Routine $routine): RedirectResponse
    {
        $routine->delete();

        return redirect()->route('admin.routines')
            ->with('success', 'Routine deleted successfully.');
    }
}
