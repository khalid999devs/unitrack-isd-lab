@php
    $role = 'student';
    $title = 'Assignments';
    $active = 'assignments';
@endphp

@extends('layouts.app')

@section('title', 'Assignments - UniTrack')

@section('content')
    <div class="space-y-6">
        <section class="rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card">
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">Assignment Board</p>
            <h1 class="mt-2 text-2xl font-bold text-main-text">Upcoming coursework</h1>
            <p class="mt-2 max-w-3xl text-sm leading-6 text-secondary-text">Assignments are loaded from courses in your current semester.</p>
        </section>

        @if ($assignments->isEmpty())
            <x-empty-state
                icon="clipboard-list"
                title="No Assignments Found"
                message="There are no assignments for your semester right now."
            />
        @else
            <section class="grid gap-6 lg:grid-cols-2">
                @foreach ($assignments as $assignment)
                    @php
                        $isOverdue = $assignment->deadline->isPast();
                    @endphp

                    <x-card class="h-full border-t-4 border-t-[#3B5BDB]">
                        <div class="flex h-full flex-col gap-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">{{ $assignment->course->course_code }}</p>
                                    <h2 class="mt-2 text-lg font-bold text-main-text">{{ $assignment->title }}</h2>
                                </div>
                                <x-badge variant="{{ $isOverdue ? 'warning' : 'success' }}">
                                    {{ $isOverdue ? 'Closed' : 'Open' }}
                                </x-badge>
                            </div>

                            <p class="text-sm leading-6 text-secondary-text">{{ $assignment->description }}</p>

                            <div class="rounded-xl bg-[#F8FBFF] px-4 py-3 text-sm text-secondary-text">
                                <span class="font-semibold text-main-text">Due date:</span> {{ $assignment->deadline->format('d M Y h:i A') }}
                            </div>

                            <div class="mt-auto flex items-center gap-2 text-sm font-semibold text-[#3B5BDB]">
                                <i class="ti ti-clipboard-list text-[18px]"></i>
                                <span>{{ $isOverdue ? 'Deadline passed' : 'Ready for submission' }}</span>
                            </div>
                        </div>
                    </x-card>
                @endforeach
            </section>
        @endif
    </div>
@endsection
