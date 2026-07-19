@php
    $role = 'admin';
    $title = 'Materials Management';
    $active = 'materials';
@endphp

@extends('layouts.app')

@section('title', 'Materials Management - UniTrack')

@section('content')
    <div class="space-y-6">
        <section class="flex flex-col gap-4 rounded-2xl border border-border-soft bg-card-bg p-5 shadow-card sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-bold text-main-text">Course resources</p>
                <p class="text-sm text-secondary-text">Manage every uploaded study material and its attached file.</p>
            </div>
            <x-button href="{{ route('admin.materials.create') }}">
                <i class="ti ti-upload mr-2 text-base" aria-hidden="true"></i>
                Upload Material
            </x-button>
        </section>

        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif

        <section class="rounded-2xl border border-border-soft bg-card-bg p-5 shadow-card">
            <form method="GET" action="{{ route('admin.materials') }}" class="grid gap-3 lg:grid-cols-[1fr_260px_auto] lg:items-end">
                <div>
                    <label for="material-search" class="mb-2 block text-sm font-semibold text-main-text">Search</label>
                    <input id="material-search" name="search" value="{{ request('search') }}" placeholder="Title, description, or course" class="h-11 w-full rounded-[10px] border border-input-border px-3 text-sm outline-none transition placeholder:text-placeholder-text focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                </div>
                <div>
                    <label for="material-course" class="mb-2 block text-sm font-semibold text-main-text">Course</label>
                    <select id="material-course" name="course_id" class="h-11 w-full rounded-[10px] border border-input-border bg-card-bg px-3 text-sm outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                        <option value="">All courses</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" @selected((string) request('course_id') === (string) $course->id)>{{ $course->course_code }} - {{ $course->course_title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <x-button type="submit">Filter</x-button>
                    @if (request()->filled('search') || request()->filled('course_id'))
                        <x-button href="{{ route('admin.materials') }}" variant="secondary">Clear</x-button>
                    @endif
                </div>
            </form>
        </section>

        @if ($materials->isEmpty())
            <x-empty-state icon="files" title="No Materials Found" message="Upload a material or change the current filters." />
        @else
            <x-table :headers="['Material', 'Course', 'Teacher', 'Uploaded', 'File', 'Actions']">
                @foreach ($materials as $material)
                    @php($hasFile = $material->file_path && \Illuminate\Support\Facades\Storage::exists($material->file_path))
                    <tr class="border-b border-border-soft transition last:border-b-0 hover:bg-muted-bg">
                        <td class="px-4 py-4">
                            <p class="font-semibold text-main-text">{{ $material->title }}</p>
                            <p class="mt-1 max-w-md text-xs text-secondary-text">{{ $material->description ?: 'No description provided.' }}</p>
                        </td>
                        <td class="px-4 py-4 text-sm">
                            <p class="font-bold text-primary-blue">{{ $material->course->course_code }}</p>
                            <p class="text-xs text-secondary-text">{{ $material->course->course_title }}</p>
                        </td>
                        <td class="px-4 py-4 text-sm text-secondary-text">{{ $material->teacher->user->name }}</td>
                        <td class="px-4 py-4 text-sm text-secondary-text">{{ $material->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-4">
                            <x-badge :variant="$hasFile ? 'success' : 'warning'">{{ $hasFile ? 'Attached' : 'Missing' }}</x-badge>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex flex-wrap gap-2">
                                @if ($hasFile)
                                    <x-button href="{{ route('admin.materials.download', $material) }}" variant="secondary" class="h-9 px-3">
                                        <i class="ti ti-download" aria-hidden="true"></i>
                                        Download
                                    </x-button>
                                @endif
                                <x-button href="{{ route('admin.materials.edit', $material) }}" variant="secondary" class="h-9 px-3">
                                    <i class="ti ti-edit" aria-hidden="true"></i>
                                    Edit
                                </x-button>
                                <form method="POST" action="{{ route('admin.materials.destroy', $material) }}" onsubmit="return confirm('Delete this material and its file?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" variant="danger" class="h-9 px-3">Delete</x-button>
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
