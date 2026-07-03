@php
    $role = 'teacher';
    $title = 'Notices';
    $active = 'notices';
@endphp

@extends('layouts.app')

@section('title', 'Notices - UniTrack')

@section('content')
    @php
        $notices = [
            ['title' => 'Guest Lecture on Cloud Computing', 'date' => '20 Jun 2026', 'posted_by' => 'Admin', 'description' => 'A guest lecture will be held next Monday in the auditorium.', 'new' => true],
            ['title' => 'Lab Equipment Maintenance', 'date' => '18 Jun 2026', 'posted_by' => 'Admin', 'description' => 'Some lab machines will be serviced this week; plan accordingly.', 'new' => false],
            ['title' => 'Project Demo Slot Allocation', 'date' => '16 Jun 2026', 'posted_by' => 'Admin', 'description' => 'Demo slots for final projects are now available to book.', 'new' => false],
            ['title' => 'Syllabus Update', 'date' => '12 Jun 2026', 'posted_by' => 'Admin', 'description' => 'Minor updates to the syllabus for the web app course have been published.', 'new' => false],
        ];
    @endphp

    <div class="space-y-6">
        <section class="rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card flex items-center justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">Notices</p>
                <h1 class="mt-1 text-2xl font-bold text-main-text">Department announcements</h1>
            </div>
            <div>
                <button class="inline-flex items-center gap-2 rounded-[10px] bg-[#3B5BDB] px-4 py-2 text-sm font-bold text-white">Post Notice</button>
            </div>
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
                    </div>
                </x-card>
            @endforeach
        </section>
    </div>
@endsection
