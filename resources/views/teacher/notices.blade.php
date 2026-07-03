@php
    $role = 'teacher';
    $title = 'Notices';
    $active = 'notices';
@endphp

@extends('layouts.app')

@section('title', 'Notices - UniTrack')

@section('content')
    <div class="space-y-6">
        <section class="flex flex-col gap-4 rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">Notices</p>
                <h1 class="mt-1 text-2xl font-bold text-main-text">Department announcements</h1>
            </div>
            <x-button href="{{ route('teacher.notices.create') }}">
                <i class="ti ti-plus mr-2 text-base"></i>
                Post Notice
            </x-button>
        </section>

        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif

        @if ($notices->isEmpty())
            <x-empty-state
                icon="bell"
                title="No Notices Found"
                message="Post a notice or wait for new department announcements."
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

                                <x-badge variant="info">{{ ucfirst($notice->target_role) }}</x-badge>
                            </div>

                            <p class="text-sm leading-6 text-secondary-text">{{ $notice->description }}</p>
                        </div>
                    </x-card>
                @endforeach
            </section>
        @endif
    </div>
@endsection
