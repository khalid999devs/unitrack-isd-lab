@php
    $role = 'admin';
    $title = 'Students';
    $active = 'students';
@endphp

@extends('layouts.app')

@section('title', 'Students - UniTrack')

@section('content')
    @php
        $students = [
            ['id' => 'S1001', 'name' => 'Ayesha Rahman', 'email' => 'ayesha.rahman@example.edu', 'dept' => 'CSE', 'batch' => '2023', 'status' => 'Active'],
            ['id' => 'S1002', 'name' => 'Karim Ahmed', 'email' => 'karim.ahmed@example.edu', 'dept' => 'CSE', 'batch' => '2022', 'status' => 'Active'],
            ['id' => 'S1003', 'name' => 'Lina Chowdhury', 'email' => 'lina.chowdhury@example.edu', 'dept' => 'EEE', 'batch' => '2023', 'status' => 'Inactive'],
            ['id' => 'S1004', 'name' => 'Rashed Khan', 'email' => 'rashed.khan@example.edu', 'dept' => 'BBA', 'batch' => '2021', 'status' => 'Active'],
            ['id' => 'S1005', 'name' => 'Mariam Sultana', 'email' => 'mariam.sultana@example.edu', 'dept' => 'CSE', 'batch' => '2024', 'status' => 'Active'],
        ];
    @endphp

    <div class="space-y-6">
        <section class="rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card flex items-center justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">Students</p>
                <h1 class="mt-1 text-2xl font-bold text-main-text">Manage student records</h1>
            </div>
            <div class="flex items-center gap-3">
                <input type="text" placeholder="Search students..." class="rounded-xl border border-input-border bg-white py-3 px-4 text-sm text-main-text shadow-sm outline-none focus:border-[#3B5BDB] focus:ring-4 focus:ring-focus-ring">
                <button class="inline-flex items-center gap-2 rounded-[10px] bg-[#3B5BDB] px-4 py-2 text-sm font-bold text-white">Add Student</button>
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
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Batch</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Status</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $s)
                            <tr class="border-b border-border-soft last:border-b-0 hover:bg-[#F8FBFF]">
                                <td class="px-4 py-4 font-semibold text-main-text">{{ $s['id'] }}</td>
                                <td class="px-4 py-4">{{ $s['name'] }}</td>
                                <td class="px-4 py-4">{{ $s['email'] }}</td>
                                <td class="px-4 py-4">{{ $s['dept'] }}</td>
                                <td class="px-4 py-4">{{ $s['batch'] }}</td>
                                <td class="px-4 py-4"><x-badge variant="{{ $s['status'] === 'Active' ? 'student' : 'error' }}">{{ $s['status'] }}</x-badge></td>
                                <td class="px-4 py-4"><button class="inline-flex items-center gap-2 rounded-[10px] bg-[#3B5BDB] px-3 py-1 text-sm font-bold text-white">View</button> <button class="inline-flex items-center gap-2 rounded-[10px] bg-[#3B5BDB] px-3 py-1 text-sm font-bold text-white">Edit</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
@endsection
