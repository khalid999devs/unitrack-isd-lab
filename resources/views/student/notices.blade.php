@php
    $role = 'student';
    $title = 'Notices';
    $active = 'notices';
@endphp

@extends('layouts.app')

@section('title', 'Notices - UniTrack')

@section('content')
    <div class="space-y-6">
        <section class="rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card">
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">Latest Notices</p>
            <h1 class="mt-2 text-2xl font-bold text-main-text">Announcements for students</h1>
            <p class="mt-2 max-w-3xl text-sm leading-6 text-secondary-text">Student and all-role notices appear here in newest-first order.</p>
        </section>

        @if ($notices->isEmpty())
            <x-empty-state
                icon="bell"
                title="No Notices Found"
                message="No student notices are available right now."
            />
        @else
            <section class="grid gap-6 lg:grid-cols-2">
                @foreach ($notices as $notice)
                    <x-card class="h-full border-l-4 border-l-[#3B5BDB]">
                        <div class="flex h-full flex-col gap-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h2 class="text-lg font-bold text-main-text">{{ $notice->title }}</h2>
                                    <p class="mt-1 text-sm text-secondary-text">
                                        Posted on {{ $notice->created_at->format('d M Y') }} by {{ $notice->postedBy?->name ?? 'System' }}
                                    </p>
                                </div>

                                @if ($loop->first)
                                    <span class="inline-flex items-center rounded-full bg-[#E7EEFF] px-3 py-1 text-xs font-bold uppercase tracking-wide text-[#3B5BDB]">New</span>
                                @endif
                            </div>

                            <p class="text-sm leading-6 text-secondary-text">{{ $notice->description }}</p>

                            <div class="mt-auto flex items-center gap-2 text-sm font-semibold text-[#3B5BDB]">
                                <i class="ti ti-bell text-[18px]"></i>
                                <span>{{ ucfirst($notice->target_role) }} notice</span>
                            </div>
                        </div>
                    </x-card>
                @endforeach
            </section>
        @endif
    </div>
@endsection
