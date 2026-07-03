@php
    $role = 'teacher';
    $title = 'Materials';
    $active = 'materials';
@endphp

@extends('layouts.app')

@section('title', 'Materials - UniTrack')

@section('content')
    <div class="space-y-6">
        <section class="flex flex-col gap-4 rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">Uploaded Materials</p>
                <h1 class="mt-1 text-2xl font-bold text-main-text">Your course files</h1>
            </div>
            <x-button href="{{ route('teacher.materials.create') }}">
                <i class="ti ti-plus mr-2 text-base"></i>
                Upload New Material
            </x-button>
        </section>

        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif

        @if ($materials->isEmpty())
            <x-empty-state
                icon="files"
                title="No Materials Uploaded"
                message="Upload a study material for one of your assigned courses."
            />
        @else
            <x-table :headers="['Material', 'Course', 'Uploaded', 'File Path', 'Actions']" emptyMessage="No materials uploaded.">
                @foreach ($materials as $material)
                    <tr class="hover:bg-muted-bg transition border-b border-border-soft last:border-b-0">
                        <td class="px-4 py-4">
                            <p class="font-semibold text-main-text">{{ $material->title }}</p>
                            @if ($material->description)
                                <p class="mt-1 max-w-md text-xs text-secondary-text">{{ $material->description }}</p>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-sm text-secondary-text">{{ $material->course->course_code }}</td>
                        <td class="px-4 py-4 text-sm text-secondary-text">{{ $material->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-4 text-sm text-secondary-text">{{ $material->file_path ?: 'Demo record' }}</td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <x-button variant="secondary" href="{{ route('teacher.materials.edit', $material) }}" class="h-9 px-3">
                                    <i class="ti ti-edit text-base"></i>
                                    Edit
                                </x-button>
                                <form method="POST" action="{{ route('teacher.materials.destroy', $material) }}" onsubmit="return confirm('Delete this material?');">
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
