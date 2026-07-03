@php
    $role = 'student';
    $title = 'Assignments';
    $active = 'assignments';
@endphp

@extends('layouts.app')

@section('title', 'Assignments - UniTrack')

@section('content')
    @php
        $assignments = [
            ['title' => 'Design a Relational Schema', 'course' => 'Database Systems', 'due' => '25 Jun 2026', 'status' => 'Pending'],
            ['title' => 'Submit Sprint Planning Report', 'course' => 'Software Engineering', 'due' => '24 Jun 2026', 'status' => 'Submitted'],
            ['title' => 'Prepare API Documentation', 'course' => 'Web Application Development', 'due' => '23 Jun 2026', 'status' => 'Pending'],
            ['title' => 'Write Reflection on Lab 4', 'course' => 'Technical Communication', 'due' => '22 Jun 2026', 'status' => 'Submitted'],
        ];
    @endphp

    <div class="space-y-6">
        <section class="rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card">
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">Assignment Board</p>
            <h1 class="mt-2 text-2xl font-bold text-main-text">Upcoming coursework</h1>
            <p class="mt-2 max-w-3xl text-sm leading-6 text-secondary-text">Static assignment cards are displayed here with pending and submitted status indicators in yellow and green.</p>
        </section>

        <section class="grid gap-6 lg:grid-cols-2">
            @foreach ($assignments as $assignment)
                @php
                    $statusClasses = $assignment['status'] === 'Submitted'
                        ? 'bg-[#E8F8EF] text-[#1F8A4C]'
                        : 'bg-[#FFF4D6] text-[#B7791F]';
                @endphp

                <x-card class="h-full border-t-4 border-t-[#3B5BDB]">
                    <div class="flex h-full flex-col gap-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">{{ $assignment['course'] }}</p>
                                <h2 class="mt-2 text-lg font-bold text-main-text">{{ $assignment['title'] }}</h2>
                            </div>
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wide {{ $statusClasses }}">
                                {{ $assignment['status'] }}
                            </span>
                        </div>

                        <div class="rounded-xl bg-[#F8FBFF] px-4 py-3 text-sm text-secondary-text">
                            <span class="font-semibold text-main-text">Due date:</span> {{ $assignment['due'] }}
                        </div>

                        <div class="mt-auto flex items-center gap-2 text-sm font-semibold text-[#3B5BDB]">
                            <i class="ti ti-clipboard-list text-[18px]"></i>
                            <span>{{ $assignment['status'] === 'Submitted' ? 'Submission received' : 'Awaiting submission' }}</span>
                        </div>
                    </div>
                </x-card>
            @endforeach
        </section>
    </div>
@endsection
