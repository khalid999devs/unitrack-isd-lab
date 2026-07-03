@php
    $role = 'admin';
    $title = 'Courses';
    $active = 'courses';
@endphp

@extends('layouts.app')

@section('title', 'Courses - UniTrack')

@section('content')
    @php
        $courses = [
            ['code' => 'CSE-301', 'name' => 'Database Systems', 'credits' => 3, 'teacher' => 'Dr. Farhana Rahman', 'enrolled' => 48, 'status' => 'Active'],
            ['code' => 'CSE-305', 'name' => 'Software Engineering', 'credits' => 3, 'teacher' => 'Mr. Hasan Mahmud', 'enrolled' => 52, 'status' => 'Active'],
            ['code' => 'ENG-201', 'name' => 'Technical Communication', 'credits' => 2, 'teacher' => 'Ms. Nabila Sultana', 'enrolled' => 62, 'status' => 'Active'],
            ['code' => 'CSE-309', 'name' => 'Web Application Development', 'credits' => 4, 'teacher' => 'Dr. Imran Hossain', 'enrolled' => 44, 'status' => 'Active'],
            ['code' => 'MTH-201', 'name' => 'Discrete Mathematics', 'credits' => 3, 'teacher' => 'Dr. Nusrat Jahan', 'enrolled' => 38, 'status' => 'Inactive'],
        ];
    @endphp

    <div class="space-y-6">
        <section class="rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card flex items-center justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">Courses</p>
                <h1 class="mt-1 text-2xl font-bold text-main-text">Course catalog</h1>
            </div>
            <div>
                <button class="inline-flex items-center gap-2 rounded-[10px] bg-[#3B5BDB] px-4 py-2 text-sm font-bold text-white">Add Course</button>
            </div>
        </section>

        <x-card class="overflow-hidden rounded-xl">
            <div class="-m-6 overflow-x-auto">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-[#3B5BDB] text-white">
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Course Code</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Course Name</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Credit Hours</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Assigned Teacher</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Enrolled Students</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Status</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $c)
                            <tr class="border-b border-border-soft last:border-b-0 hover:bg-[#F8FBFF]">
                                <td class="px-4 py-4 font-semibold text-main-text">{{ $c['code'] }}</td>
                                <td class="px-4 py-4">{{ $c['name'] }}</td>
                                <td class="px-4 py-4">{{ $c['credits'] }}</td>
                                <td class="px-4 py-4">{{ $c['teacher'] }}</td>
                                <td class="px-4 py-4">{{ $c['enrolled'] }}</td>
                                <td class="px-4 py-4"><x-badge variant="{{ $c['status'] === 'Active' ? 'student' : 'error' }}">{{ $c['status'] }}</x-badge></td>
                                <td class="px-4 py-4"><button class="inline-flex items-center gap-2 rounded-[10px] bg-[#3B5BDB] px-3 py-1 text-sm font-bold text-white">View</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
@endsection
