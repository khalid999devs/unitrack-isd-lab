@php
    $role = 'student';
    $title = 'Courses';
    $active = 'courses';
@endphp

@extends('layouts.app')

@section('title', 'Courses - UniTrack')

@section('content')
    @php
        $courses = [
            ['code' => 'CSE-301', 'name' => 'Database Systems', 'teacher' => 'Dr. Farhana Rahman', 'credits' => 3],
            ['code' => 'CSE-305', 'name' => 'Software Engineering', 'teacher' => 'Mr. Hasan Mahmud', 'credits' => 3],
            ['code' => 'ENG-201', 'name' => 'Technical Communication', 'teacher' => 'Ms. Nabila Sultana', 'credits' => 2],
            ['code' => 'CSE-309', 'name' => 'Web Application Development', 'teacher' => 'Dr. Imran Hossain', 'credits' => 4],
        ];
    @endphp

    <div class="space-y-6">
        <section class="flex flex-col gap-4 rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">Student Courses</p>
                <h1 class="mt-2 text-2xl font-bold text-main-text">My enrolled courses</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-secondary-text">Demo course cards are shown here to preview the student course management page.</p>
            </div>

            <div class="w-full max-w-md">
                <label for="course-search" class="mb-2 block text-sm font-semibold text-main-text">Search courses</label>
                <div class="relative">
                    <i class="ti ti-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-[18px] text-[#3B5BDB]"></i>
                    <input
                        id="course-search"
                        type="text"
                        placeholder="Search by code, course name, or teacher"
                        class="w-full rounded-xl border border-input-border bg-white py-3 pl-11 pr-4 text-sm text-main-text shadow-sm outline-none transition focus:border-[#3B5BDB] focus:ring-4 focus:ring-focus-ring"
                    >
                </div>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-3">
            @foreach ($courses as $course)
                <x-card class="h-full border-t-4 border-t-[#3B5BDB]">
                    <div class="flex h-full flex-col gap-5">
                        <div class="flex items-center justify-between gap-4 overflow-hidden">
                            <div class="min-w-0">
                                <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">{{ $course['code'] }}</p>
                                <h2 class="mt-2 text-lg font-bold text-main-text">{{ $course['name'] }}</h2>
                            </div>
                            <span class="shrink-0 inline-flex items-center rounded-full bg-[#E7EEFF] px-3 py-1 text-xs font-bold uppercase tracking-wide text-[#3B5BDB]">Active</span>
                        </div>

                        <div class="space-y-3 text-sm text-secondary-text">
                            <div class="flex items-center gap-3 rounded-xl bg-[#F8FBFF] px-4 py-3">
                                <i class="ti ti-user text-[18px] text-[#3B5BDB]"></i>
                                <div>
                                    <p class="font-semibold text-main-text">Teacher</p>
                                    <p>{{ $course['teacher'] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 rounded-xl bg-[#F8FBFF] px-4 py-3">
                                <i class="ti ti-books text-[18px] text-[#3B5BDB]"></i>
                                <div>
                                    <p class="font-semibold text-main-text">Credit Hours</p>
                                    <p>{{ $course['credits'] }} credits</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-card>
            @endforeach
        </section>
    </div>
@endsection
