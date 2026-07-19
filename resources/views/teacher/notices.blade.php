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
                <p class="text-sm font-bold text-main-text">Department announcements</p>
                <p class="text-sm text-secondary-text">Read role announcements and manage notices posted by you.</p>
            </div>
            <x-button href="{{ route('teacher.notices.create') }}">
                <i class="ti ti-plus mr-2 text-base"></i>
                Post Notice
            </x-button>
        </section>

        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif

        <section class="rounded-2xl border border-border-soft bg-card-bg p-5 shadow-card">
            <form method="GET" action="{{ route('teacher.notices') }}" class="flex flex-col gap-3 sm:flex-row">
                <input name="search" value="{{ request('search') }}" placeholder="Search notice title or description" class="h-11 flex-1 rounded-[10px] border border-input-border px-3 text-sm outline-none transition placeholder:text-placeholder-text focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                <x-button type="submit">Search</x-button>
                @if (request()->filled('search'))<x-button href="{{ route('teacher.notices') }}" variant="secondary">Clear</x-button>@endif
            </form>
        </section>

        @if ($notices->isEmpty())
            <x-empty-state
                icon="bell"
                title="No Notices Found"
                message="Post a notice or wait for new department announcements."
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

                                <x-badge variant="info">{{ ucfirst($notice->target_role) }}</x-badge>
                            </div>

                            <p class="text-sm leading-6 text-secondary-text">{{ $notice->description }}</p>

                            @if ($notice->posted_by === auth()->id())
                                <div class="mt-auto flex flex-wrap justify-end gap-2">
                                    <x-button href="{{ route('teacher.notices.edit', $notice) }}" variant="secondary" class="h-9 px-3">Edit</x-button>
                                    <form method="POST" action="{{ route('teacher.notices.destroy', $notice) }}" onsubmit="return confirm('Delete this notice?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="submit" variant="danger" class="h-9 px-3">Delete</x-button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </x-card>
                @endforeach
            </section>
            @if ($notices->hasPages())
                <div>{{ $notices->links() }}</div>
            @endif
        @endif
    </div>
@endsection
