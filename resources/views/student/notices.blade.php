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
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-primary-blue">Latest Notices</p>
            <h1 class="mt-2 text-2xl font-bold text-main-text">Announcements for students</h1>
            <p class="mt-2 max-w-3xl text-sm leading-6 text-secondary-text">Student and all-role notices appear here in newest-first order.</p>
        </section>

        <section class="rounded-2xl border border-border-soft bg-card-bg p-5 shadow-card">
            <form method="GET" action="{{ route('student.notices') }}" class="flex flex-col gap-3 sm:flex-row">
                <div class="relative flex-1">
                    <i class="ti ti-search pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-lg text-secondary-text"></i>
                    <input name="search" value="{{ request('search') }}" placeholder="Search notice title or details" class="h-11 w-full rounded-[10px] border border-input-border pl-10 pr-3 text-sm outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                </div>
                <x-button type="submit">Search</x-button>
                @if (request()->filled('search'))
                    <x-button href="{{ route('student.notices') }}" variant="secondary">Clear</x-button>
                @endif
            </form>
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
                    <x-card class="h-full border-l-4 border-l-primary-blue">
                        <div class="flex h-full flex-col gap-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h2 class="text-lg font-bold text-main-text">{{ $notice->title }}</h2>
                                    <p class="mt-1 text-sm text-secondary-text">
                                        Posted on {{ $notice->created_at->format('d M Y') }} by {{ $notice->postedBy?->name ?? 'System' }}
                                    </p>
                                </div>

                                @if ($loop->first)
                                    <span class="inline-flex items-center rounded-full bg-soft-blue-bg px-3 py-1 text-xs font-bold uppercase tracking-wide text-primary-blue">New</span>
                                @endif
                            </div>

                            <p class="text-sm leading-6 text-secondary-text">{{ $notice->description }}</p>

                            <div class="mt-auto flex items-center gap-2 text-sm font-semibold text-primary-blue">
                                <i class="ti ti-bell text-[18px]"></i>
                                <span>{{ ucfirst($notice->target_role) }} notice</span>
                            </div>
                        </div>
                    </x-card>
                @endforeach
            </section>
        @endif

        @if ($notices->hasPages())
            {{ $notices->links() }}
        @endif
    </div>
@endsection
