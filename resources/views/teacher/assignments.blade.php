@php
    $role = 'teacher';
    $title = 'Assignments';
    $active = 'assignments';
@endphp

@extends('layouts.app')

@section('title', 'Assignments - UniTrack')

@section('content')
    @php
        $assignments = [
            ['title' => 'ER Diagram Submission', 'course' => 'Database Systems', 'due' => '28 Jun 2026', 'submissions' => 45],
            ['title' => 'Module Interface Design', 'course' => 'Software Architecture', 'due' => '30 Jun 2026', 'submissions' => 33],
            ['title' => 'Client-side Validation Task', 'course' => 'Web Application Development', 'due' => '02 Jul 2026', 'submissions' => 39],
        ];
    @endphp

    <div class="space-y-6">
        <section class="flex flex-col gap-4 rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">Assignments</p>
                <h1 class="mt-2 text-2xl font-bold text-main-text">Manage coursework and submissions</h1>
            </div>
            <button type="button" class="inline-flex items-center justify-center gap-2 rounded-[10px] bg-[#3B5BDB] px-4 py-2 text-sm font-bold text-white transition hover:bg-[#2F49C6]">
                <i class="ti ti-plus text-base"></i>
                Add Assignment
            </button>
        </section>

        <section class="grid gap-6 lg:grid-cols-2">
            @foreach ($assignments as $a)
                <x-card class="h-full border-t-4 border-t-[#3B5BDB]">
                    <div class="flex h-full flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-lg font-bold text-main-text">{{ $a['title'] }}</h2>
                                <p class="text-sm text-secondary-text">{{ $a['course'] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-main-text">Due {{ $a['due'] }}</p>
                                <p class="text-sm text-secondary-text">{{ $a['submissions'] }} submissions</p>
                            </div>
                        </div>

                        <div class="mt-auto flex justify-end">
                            <button class="inline-flex items-center gap-2 rounded-[10px] bg-[#3B5BDB] px-4 py-2 text-sm font-bold text-white">View Submissions</button>
                        </div>
                    </div>
                </x-card>
            @endforeach
        </section>
    </div>
@endsection
