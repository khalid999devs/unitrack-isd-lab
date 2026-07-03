@php
    $role = 'student';
    $title = 'Materials';
    $active = 'materials';
@endphp

@extends('layouts.app')

@section('title', 'Materials - UniTrack')

@section('content')
    @php
        $materials = [
            ['name' => 'Chapter 7 Lecture Slides.pdf', 'course' => 'Database Systems', 'uploaded_by' => 'Dr. Farhana Rahman', 'date' => '22 Jun 2026'],
            ['name' => 'Lab 4 Source Files.zip', 'course' => 'Web Application Development', 'uploaded_by' => 'Dr. Imran Hossain', 'date' => '21 Jun 2026'],
            ['name' => 'Grammar Notes and Examples.docx', 'course' => 'Technical Communication', 'uploaded_by' => 'Ms. Nabila Sultana', 'date' => '20 Jun 2026'],
            ['name' => 'Assignment Brief.pdf', 'course' => 'Software Engineering', 'uploaded_by' => 'Mr. Hasan Mahmud', 'date' => '19 Jun 2026'],
            ['name' => 'Practice Questions.pdf', 'course' => 'Discrete Mathematics', 'uploaded_by' => 'Dr. Nusrat Jahan', 'date' => '18 Jun 2026'],
        ];
    @endphp

    <div class="space-y-6">
        <section class="rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card">
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">Study Materials</p>
            <h1 class="mt-2 text-2xl font-bold text-main-text">Course files and downloads</h1>
            <p class="mt-2 max-w-3xl text-sm leading-6 text-secondary-text">Five demo materials are shown below in a clean row layout with file icons and download actions.</p>
        </section>

        <x-card class="overflow-hidden rounded-xl">
            <div class="-m-6 overflow-x-auto">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-[#3B5BDB] text-white">
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Material</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Course</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Uploaded By</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Upload Date</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materials as $material)
                            <tr class="border-b border-border-soft last:border-b-0 hover:bg-[#F8FBFF]">
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E7EEFF] text-[#3B5BDB]">
                                            <i class="ti ti-file-text text-[20px]"></i>
                                        </div>
                                        <span class="font-semibold text-main-text">{{ $material['name'] }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-secondary-text">{{ $material['course'] }}</td>
                                <td class="px-4 py-4 text-secondary-text">{{ $material['uploaded_by'] }}</td>
                                <td class="px-4 py-4 text-secondary-text">{{ $material['date'] }}</td>
                                <td class="px-4 py-4">
                                    <a href="#" class="inline-flex items-center gap-2 rounded-xl bg-[#3B5BDB] px-4 py-2 text-sm font-bold text-white transition hover:bg-[#334FCC]">
                                        <i class="ti ti-download text-[18px]"></i>
                                        Download
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
@endsection
