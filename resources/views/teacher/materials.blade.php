@php
    $role = 'teacher';
    $title = 'Materials';
    $active = 'materials';
@endphp

@extends('layouts.app')

@section('title', 'Materials - UniTrack')

@section('content')
    @php
        $materials = [
            ['name' => 'Lecture 5 - Transactions.pdf', 'course' => 'Database Systems', 'date' => '18 Jun 2026', 'size' => '1.2 MB'],
            ['name' => 'Lab 2 Materials.zip', 'course' => 'Web Application Development', 'date' => '15 Jun 2026', 'size' => '4.8 MB'],
            ['name' => 'API Examples.docx', 'course' => 'Software Architecture', 'date' => '12 Jun 2026', 'size' => '680 KB'],
            ['name' => 'Assignment 3 Brief.pdf', 'course' => 'Software Engineering', 'date' => '10 Jun 2026', 'size' => '320 KB'],
        ];
    @endphp

    <div class="space-y-6">
        <section class="rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card flex items-center justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">Uploaded Materials</p>
                <h1 class="mt-1 text-2xl font-bold text-main-text">Your course files</h1>
            </div>
            <div>
                <button class="inline-flex items-center gap-2 rounded-[10px] bg-[#3B5BDB] px-4 py-2 text-sm font-bold text-white">Upload New Material</button>
            </div>
        </section>

        <x-card class="overflow-hidden rounded-xl">
            <div class="-m-6 overflow-x-auto">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-[#3B5BDB] text-white">
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Material Name</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Course</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Upload Date</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">File Size</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materials as $m)
                            <tr class="border-b border-border-soft last:border-b-0 hover:bg-[#F8FBFF]">
                                <td class="px-4 py-4 font-semibold text-main-text">{{ $m['name'] }}</td>
                                <td class="px-4 py-4 text-secondary-text">{{ $m['course'] }}</td>
                                <td class="px-4 py-4 text-secondary-text">{{ $m['date'] }}</td>
                                <td class="px-4 py-4 text-secondary-text">{{ $m['size'] }}</td>
                                <td class="px-4 py-4">
                                    <button class="mr-2 inline-flex items-center gap-2 rounded-[10px] bg-[#3B5BDB] px-3 py-1 text-sm font-bold text-white">Edit</button>
                                    <button class="inline-flex items-center gap-2 rounded-[10px] bg-[#3B5BDB] px-3 py-1 text-sm font-bold text-white">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
@endsection
