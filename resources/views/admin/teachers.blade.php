@php
    $role = 'admin';
    $title = 'Teachers';
    $active = 'teachers';
@endphp

@extends('layouts.app')

@section('title', 'Teachers - UniTrack')

@section('content')
    @php
        $teachers = [
            ['id' => 'T2001', 'name' => 'Dr. Farhana Rahman', 'email' => 'farhana.rahman@example.edu', 'dept' => 'CSE', 'courses' => 4],
            ['id' => 'T2002', 'name' => 'Mr. Hasan Mahmud', 'email' => 'hasan.mahmud@example.edu', 'dept' => 'CSE', 'courses' => 3],
            ['id' => 'T2003', 'name' => 'Dr. Imran Hossain', 'email' => 'imran.hossain@example.edu', 'dept' => 'CSE', 'courses' => 5],
            ['id' => 'T2004', 'name' => 'Ms. Nabila Sultana', 'email' => 'nabila.sultana@example.edu', 'dept' => 'English', 'courses' => 2],
        ];
    @endphp

    <div class="space-y-6">
        <section class="rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card flex items-center justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">Teachers</p>
                <h1 class="mt-1 text-2xl font-bold text-main-text">Manage teaching staff</h1>
            </div>
            <div>
                <button class="inline-flex items-center gap-2 rounded-[10px] bg-[#3B5BDB] px-4 py-2 text-sm font-bold text-white">Add Teacher</button>
            </div>
        </section>

        <x-card class="overflow-hidden rounded-xl">
            <div class="-m-6 overflow-x-auto">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-[#3B5BDB] text-white">
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">ID</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Name</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Email</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Department</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Assigned Courses</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teachers as $t)
                            <tr class="border-b border-border-soft last:border-b-0 hover:bg-[#F8FBFF]">
                                <td class="px-4 py-4 font-semibold text-main-text">{{ $t['id'] }}</td>
                                <td class="px-4 py-4">{{ $t['name'] }}</td>
                                <td class="px-4 py-4">{{ $t['email'] }}</td>
                                <td class="px-4 py-4">{{ $t['dept'] }}</td>
                                <td class="px-4 py-4">{{ $t['courses'] }}</td>
                                <td class="px-4 py-4"><button class="inline-flex items-center gap-2 rounded-[10px] bg-[#3B5BDB] px-3 py-1 text-sm font-bold text-white">View</button> <button class="inline-flex items-center gap-2 rounded-[10px] bg-[#3B5BDB] px-3 py-1 text-sm font-bold text-white">Edit</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
@endsection
