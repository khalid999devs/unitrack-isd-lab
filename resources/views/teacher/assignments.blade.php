@php
    $role = 'teacher';
    $title = 'Assignments';
    $active = 'assignments';
@endphp

@extends('layouts.app')

@section('title', 'Assignments - UniTrack')

@section('content')
    <div class="space-y-6">
        <section class="flex flex-col gap-4 rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">Assignments</p>
                <h1 class="mt-2 text-2xl font-bold text-main-text">Manage coursework and submissions</h1>
            </div>
            <x-button href="{{ route('teacher.assignments.create') }}">
                <i class="ti ti-plus text-base"></i>
                Add Assignment
            </x-button>
        </section>

        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif

        @if ($assignments->isEmpty())
            <x-empty-state
                icon="clipboard-list"
                title="No Assignments Created"
                message="Create an assignment for one of your assigned courses."
            />
        @else
            <section class="grid gap-6 lg:grid-cols-2">
                @foreach ($assignments as $assignment)
                    <x-card class="h-full border-t-4 border-t-[#3B5BDB]">
                        <div class="flex h-full flex-col gap-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h2 class="text-lg font-bold text-main-text">{{ $assignment->title }}</h2>
                                    <p class="text-sm text-secondary-text">{{ $assignment->course->course_code }} - {{ $assignment->course->course_title }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-main-text">Due {{ $assignment->deadline->format('d M Y') }}</p>
                                    <p class="text-sm text-secondary-text">{{ $assignment->deadline->format('h:i A') }}</p>
                                </div>
                            </div>

                            <p class="text-sm leading-6 text-secondary-text">{{ $assignment->description }}</p>

                            <div class="mt-auto flex justify-end">
                                <x-button href="{{ route('teacher.assignments.submissions', $assignment) }}" class="h-10">
                                    View Submissions
                                </x-button>
                            </div>
                        </div>
                    </x-card>
                @endforeach
            </section>
        @endif
    </div>
@endsection
