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
                <p class="text-sm font-bold text-main-text">Your course files</p>
                <p class="text-sm text-secondary-text">Upload, download, replace, or remove your course resources.</p>
            </div>
            <x-button href="{{ route('teacher.materials.create') }}">
                <i class="ti ti-plus mr-2 text-base"></i>
                Upload New Material
            </x-button>
        </section>

        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif

        <section class="rounded-2xl border border-border-soft bg-card-bg p-5 shadow-card">
            <form method="GET" action="{{ route('teacher.materials') }}" class="grid gap-3 lg:grid-cols-[1fr_240px_auto] lg:items-end">
                <div>
                    <label for="material-search" class="mb-2 block text-sm font-semibold text-main-text">Search</label>
                    <input id="material-search" name="search" value="{{ request('search') }}" placeholder="Title or description" class="h-11 w-full rounded-[10px] border border-input-border px-3 text-sm outline-none transition placeholder:text-placeholder-text focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                </div>
                <div>
                    <label for="material-course" class="mb-2 block text-sm font-semibold text-main-text">Course</label>
                    <select id="material-course" name="course_id" class="h-11 w-full rounded-[10px] border border-input-border bg-card-bg px-3 text-sm outline-none focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                        <option value="">All courses</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" @selected((string) request('course_id') === (string) $course->id)>{{ $course->course_code }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <x-button type="submit">Filter</x-button>
                    @if (request()->hasAny(['search', 'course_id']))<x-button href="{{ route('teacher.materials') }}" variant="secondary">Clear</x-button>@endif
                </div>
            </form>
        </section>

        @if ($materials->isEmpty())
            <x-empty-state
                icon="files"
                title="No Materials Uploaded"
                message="Upload a study material for one of your assigned courses."
            />
        @else
            <x-table :headers="['Material', 'Course', 'Uploaded', 'File', 'Actions']" emptyMessage="No materials uploaded.">
                @foreach ($materials as $material)
                    @php
                        $hasFile = $material->file_path && \Illuminate\Support\Facades\Storage::exists($material->file_path);
                    @endphp
                    <tr class="hover:bg-muted-bg transition border-b border-border-soft last:border-b-0">
                        <td class="px-4 py-4">
                            <p class="font-semibold text-main-text">{{ $material->title }}</p>
                            @if ($material->description)
                                <p class="mt-1 max-w-md text-xs text-secondary-text">{{ $material->description }}</p>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-sm text-secondary-text">{{ $material->course->course_code }}</td>
                        <td class="px-4 py-4 text-sm text-secondary-text">{{ $material->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-4">
                            @if ($hasFile)
                                <x-badge variant="success">Attached</x-badge>
                            @else
                                <x-badge variant="warning">No file</x-badge>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                @if ($hasFile)
                                    <x-button variant="secondary" href="{{ route('teacher.materials.download', $material) }}" class="h-9 px-3">
                                        <i class="ti ti-download text-base" aria-hidden="true"></i>
                                        Download
                                    </x-button>
                                @endif
                                <x-button variant="secondary" href="{{ route('teacher.materials.edit', $material) }}" class="h-9 px-3">
                                    <i class="ti ti-edit text-base"></i>
                                    Edit
                                </x-button>
                                <form method="POST" action="{{ route('teacher.materials.destroy', $material) }}" onsubmit="return confirm('Delete this material?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex h-9 items-center gap-2 rounded-[10px] bg-error/10 px-3 text-sm font-bold text-error transition hover:bg-error hover:text-on-primary">
                                        <i class="ti ti-trash text-base"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-table>
            @if ($materials->hasPages())
                <div>{{ $materials->links() }}</div>
            @endif
        @endif
    </div>
@endsection
