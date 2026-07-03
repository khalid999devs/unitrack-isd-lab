@php
    $role = 'admin';
    $title = 'Notices';
    $active = 'notices';
@endphp

@extends('layouts.app')

@section('title', 'Notices - UniTrack')

@section('content')
    <div class="space-y-6">
        <section class="flex flex-col gap-4 rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-bold text-main-text">Institution announcements</p>
                <p class="text-sm text-secondary-text">Create and maintain notices for each role audience.</p>
            </div>
            <x-button href="{{ route('admin.notices.create') }}">
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
                title="No Notices Posted"
                message="Create the first institution notice for UniTrack."
            />
        @else
            <x-table :headers="['Title', 'Posted By', 'Date', 'Target', 'Actions']" emptyMessage="No notices posted.">
                @foreach ($notices as $notice)
                    <tr class="hover:bg-muted-bg transition border-b border-border-soft last:border-b-0">
                        <td class="px-4 py-4">
                            <p class="font-semibold text-main-text">{{ $notice->title }}</p>
                            <p class="mt-1 max-w-md text-xs text-secondary-text">{{ $notice->description }}</p>
                        </td>
                        <td class="px-4 py-4 text-sm text-secondary-text">{{ $notice->postedBy?->name ?? 'System' }}</td>
                        <td class="px-4 py-4 text-sm text-secondary-text">{{ $notice->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-4"><x-badge variant="info">{{ ucfirst($notice->target_role) }}</x-badge></td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <x-button variant="secondary" href="{{ route('admin.notices.edit', $notice) }}" class="h-9 px-3">
                                    <i class="ti ti-edit text-base"></i>
                                    Edit
                                </x-button>
                                <form method="POST" action="{{ route('admin.notices.destroy', $notice) }}" onsubmit="return confirm('Delete this notice?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex h-9 items-center gap-2 rounded-[10px] bg-error/10 px-3 text-sm font-bold text-error transition hover:bg-error hover:text-white">
                                        <i class="ti ti-trash text-base"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        @endif
    </div>
@endsection
