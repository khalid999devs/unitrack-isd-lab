@php
    $role = 'student';
    $title = 'Notices';
    $active = 'notices';
@endphp

@extends('layouts.app')

@section('title', 'Notices - UniTrack')

@section('content')
    @php
        $notices = [
            ['title' => 'Midterm Exam Schedule Published', 'date' => '22 Jun 2026', 'posted_by' => 'Admin', 'description' => 'The midterm examination timetable has been released. Students should review the room allocation and arrive 15 minutes early.', 'new' => true],
            ['title' => 'Library Evening Access Extended', 'date' => '21 Jun 2026', 'posted_by' => 'Admin', 'description' => 'The library will remain open until 8:00 PM for the next two weeks to support revision and project work.', 'new' => true],
            ['title' => 'Submission Reminder for Lab Report', 'date' => '19 Jun 2026', 'posted_by' => 'Admin', 'description' => 'All students enrolled in the web application course must submit their lab report before the deadline.', 'new' => false],
            ['title' => 'Sports Club Registration Window', 'date' => '17 Jun 2026', 'posted_by' => 'Admin', 'description' => 'Registration is open for inter-department sports activities. Interested students can sign up at the office counter.', 'new' => false],
        ];
    @endphp

    <div class="space-y-6">
        <section class="rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card">
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">Latest Notices</p>
            <h1 class="mt-2 text-2xl font-bold text-main-text">Announcements for students</h1>
            <p class="mt-2 max-w-3xl text-sm leading-6 text-secondary-text">Demo notices are shown here with recent items marked as new using the same blue theme.</p>
        </section>

        <section class="grid gap-6 lg:grid-cols-2">
            @foreach ($notices as $notice)
                <x-card class="h-full border-l-4 border-l-[#3B5BDB]">
                    <div class="flex h-full flex-col gap-4">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-lg font-bold text-main-text">{{ $notice['title'] }}</h2>
                                <p class="mt-1 text-sm text-secondary-text">Posted on {{ $notice['date'] }} by {{ $notice['posted_by'] }}</p>
                            </div>

                            @if ($notice['new'])
                                <span class="inline-flex items-center rounded-full bg-[#E7EEFF] px-3 py-1 text-xs font-bold uppercase tracking-wide text-[#3B5BDB]">New</span>
                            @endif
                        </div>

                        <p class="text-sm leading-6 text-secondary-text">{{ $notice['description'] }}</p>

                        <div class="mt-auto flex items-center gap-2 text-sm font-semibold text-[#3B5BDB]">
                            <i class="ti ti-bell text-[18px]"></i>
                            <span>Posted by Admin</span>
                        </div>
                    </div>
                </x-card>
            @endforeach
        </section>
    </div>
@endsection
