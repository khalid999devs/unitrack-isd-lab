@php
    $role = 'teacher';
    $title = 'Assigned Courses';
    $active = 'courses';
@endphp

@extends('layouts.app')

@section('title', 'Assigned Courses - UniTrack')

@section('content')
    @php
        $courses = [
            ['code' => 'CSE-301', 'name' => 'Database Systems', 'students' => 48, 'semester' => 'Spring 2026'],
            ['code' => 'CSE-309', 'name' => 'Web Application Development', 'students' => 42, 'semester' => 'Spring 2026'],
            ['code' => 'CSE-321', 'name' => 'Software Architecture', 'students' => 36, 'semester' => 'Fall 2026'],
        ];
    @endphp

    <div class="space-y-6">
        <section class="rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card flex items-center justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">Assigned Courses</p>
                <h1 class="mt-1 text-2xl font-bold text-main-text">Courses you're teaching</h1>
            </div>
            <div>
                <button class="inline-flex items-center gap-2 rounded-[10px] bg-[#3B5BDB] px-4 py-2 text-sm font-bold text-white">Upload Material</button>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-3">
            @foreach ($courses as $course)
                <x-card class="h-full border-t-4 border-t-[#3B5BDB]">
                    <div class="flex h-full flex-col gap-4">
                        <div class="flex items-center justify-between gap-4 overflow-hidden">
                            <div class="min-w-0">
                                <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">{{ $course['code'] }}</p>
                                <h2 class="mt-1 text-lg font-bold text-main-text">{{ $course['name'] }}</h2>
                            </div>
                            <span class="shrink-0 inline-flex items-center rounded-full bg-[#E7EEFF] px-3 py-1 text-xs font-bold uppercase tracking-wide text-[#3B5BDB]">Active</span>
                        </div>

                        <div class="flex items-center justify-between gap-4 text-sm text-secondary-text">
                            <div>
                                <p class="font-semibold text-main-text">Enrolled</p>
                                <p>{{ $course['students'] }} students</p>
                            </div>
                            <div>
                                <p class="font-semibold text-main-text">Semester</p>
                                <p>{{ $course['semester'] }}</p>
                            </div>
                        </div>

                        <div class="mt-auto flex items-center justify-end gap-2">
                            <button class="inline-flex items-center gap-2 rounded-[10px] bg-[#3B5BDB] px-4 py-2 text-sm font-bold text-white">Upload Material</button>
                        </div>
                    </div>
                </x-card>
            @endforeach
        </section>
    </div>
@endsection
