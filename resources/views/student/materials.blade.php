@php
    $role = 'student';
    $title = 'Materials';
    $active = 'materials';
@endphp

@extends('layouts.app')

@section('title', 'Materials - UniTrack')

@section('content')
    <div class="space-y-6">
        <section class="rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card">
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-primary-blue">Study Materials</p>
            <h1 class="mt-2 text-2xl font-bold text-main-text">Course files and downloads</h1>
            <p class="mt-2 max-w-3xl text-sm leading-6 text-secondary-text">Materials are limited to courses in your department and semester.</p>
        </section>

        <section class="rounded-2xl border border-border-soft bg-card-bg p-5 shadow-card">
            <form method="GET" action="{{ route('student.materials') }}" class="grid gap-4 sm:grid-cols-[minmax(0,2fr)_minmax(0,1fr)_auto] sm:items-end">
                <div>
                    <label for="search" class="mb-2 block text-sm font-semibold text-main-text">Search</label>
                    <input id="search" name="search" value="{{ request('search') }}" placeholder="Title or description" class="h-11 w-full rounded-[10px] border border-input-border px-3 text-sm outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                </div>
                <div>
                    <label for="course_id" class="mb-2 block text-sm font-semibold text-main-text">Course</label>
                    <select id="course_id" name="course_id" class="h-11 w-full rounded-[10px] border border-input-border bg-card-bg px-3 text-sm outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                        <option value="">All courses</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ (string) request('course_id') === (string) $course->id ? 'selected' : '' }}>{{ $course->course_code }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <x-button type="submit">Filter</x-button>
                    @if (request()->hasAny(['search', 'course_id']))
                        <x-button href="{{ route('student.materials') }}" variant="secondary">Clear</x-button>
                    @endif
                </div>
            </form>
        </section>

        @if ($materials->isEmpty())
            <x-empty-state
                icon="files"
                title="No Materials Found"
                message="No study materials are available for your semester yet."
            />
        @else
            <x-table :headers="['Material', 'Course', 'Uploaded By', 'Upload Date', 'Action']" emptyMessage="No materials available.">
                @foreach ($materials as $material)
                    @php
                        $hasFile = $material->file_path && \Illuminate\Support\Facades\Storage::exists($material->file_path);
                    @endphp
                    <tr class="hover:bg-muted-bg transition border-b border-border-soft last:border-b-0">
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-soft-blue-bg text-primary-blue">
                                    <i class="ti ti-file-text text-[20px]"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-main-text">{{ $material->title }}</p>
                                    @if ($material->description)
                                        <p class="mt-1 max-w-sm text-xs text-secondary-text">{{ $material->description }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-secondary-text">{{ $material->course->course_code }}</td>
                        <td class="px-4 py-4 text-secondary-text">{{ $material->teacher->user->name }}</td>
                        <td class="px-4 py-4 text-secondary-text">{{ $material->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-4">
                            @if ($hasFile)
                                <a href="{{ route('student.materials.download', $material) }}" class="inline-flex items-center gap-2 rounded-[10px] bg-primary-blue px-4 py-2 text-sm font-bold text-on-primary transition hover:bg-royal-blue">
                                    <i class="ti ti-download text-[18px]"></i>
                                    Download
                                </a>
                            @else
                                <x-badge variant="warning">No file</x-badge>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </x-table>
        @endif

        @if ($materials->hasPages())
            {{ $materials->links() }}
        @endif
    </div>
@endsection
