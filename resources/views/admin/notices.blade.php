@php
    $role = 'admin';
    $title = 'Notices';
    $active = 'notices';
@endphp

@extends('layouts.app')

@section('title', 'Notices - UniTrack')

@section('content')
    @php
        $notices = [
            ['title' => 'Semester Registration Opens', 'posted_by' => 'Admin', 'date' => '20 Jun 2026', 'target' => 'All'],
            ['title' => 'Faculty Meeting', 'posted_by' => 'Admin', 'date' => '18 Jun 2026', 'target' => 'Teachers'],
            ['title' => 'Scholarship Applications', 'posted_by' => 'Admin', 'date' => '15 Jun 2026', 'target' => 'Students'],
            ['title' => 'Campus Maintenance', 'posted_by' => 'Admin', 'date' => '12 Jun 2026', 'target' => 'All'],
        ];
    @endphp

    <div class="space-y-6">
        <section class="rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card flex items-center justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">Notices</p>
                <h1 class="mt-1 text-2xl font-bold text-main-text">Institution announcements</h1>
            </div>
            <div>
                <button class="inline-flex items-center gap-2 rounded-[10px] bg-[#3B5BDB] px-4 py-2 text-sm font-bold text-white">Post Notice</button>
            </div>
        </section>

        <x-card class="overflow-hidden rounded-xl">
            <div class="-m-6 overflow-x-auto">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-[#3B5BDB] text-white">
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Title</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Posted By</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Date</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Target</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notices as $n)
                            <tr class="border-b border-border-soft last:border-b-0 hover:bg-[#F8FBFF]">
                                <td class="px-4 py-4 font-semibold text-main-text">{{ $n['title'] }}</td>
                                <td class="px-4 py-4">{{ $n['posted_by'] }}</td>
                                <td class="px-4 py-4">{{ $n['date'] }}</td>
                                <td class="px-4 py-4">{{ $n['target'] }}</td>
                                <td class="px-4 py-4"><button class="mr-2 inline-flex items-center gap-2 rounded-[10px] bg-[#3B5BDB] px-3 py-1 text-sm font-bold text-white">Edit</button> <button class="inline-flex items-center gap-2 rounded-[10px] bg-[#3B5BDB] px-3 py-1 text-sm font-bold text-white">Delete</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
@endsection
