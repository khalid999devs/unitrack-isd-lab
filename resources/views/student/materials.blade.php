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
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">Study Materials</p>
            <h1 class="mt-2 text-2xl font-bold text-main-text">Course files and downloads</h1>
            <p class="mt-2 max-w-3xl text-sm leading-6 text-secondary-text">Materials are filtered from courses in your current semester.</p>
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
                    <tr class="hover:bg-muted-bg transition border-b border-border-soft last:border-b-0">
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E7EEFF] text-[#3B5BDB]">
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
                            <a href="{{ route('student.materials.download', $material) }}" class="inline-flex items-center gap-2 rounded-xl bg-[#3B5BDB] px-4 py-2 text-sm font-bold text-white transition hover:bg-[#334FCC]">
                                <i class="ti ti-download text-[18px]"></i>
                                Download
                            </a>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        @endif
    </div>
@endsection
