@php
    $role = 'admin';
    $title = 'Routines';
    $active = 'routines';
@endphp

@extends('layouts.app')

@section('title', 'Routines - UniTrack')

@section('content')
    @php
        $days = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'];
        $routineRows = [
            ['time' => '08:30 - 09:20', 'Saturday' => 'Database Systems<br><span class="text-xs text-secondary-text">Room 402</span>', 'Sunday' => '—', 'Monday' => 'Software Engineering<br><span class="text-xs text-secondary-text">Room 305</span>', 'Tuesday' => '—', 'Wednesday' => 'Web App Lab<br><span class="text-xs text-secondary-text">Lab 2</span>', 'Thursday' => '—'],
            ['time' => '09:30 - 10:20', 'Saturday' => '—', 'Sunday' => 'Technical Communication<br><span class="text-xs text-secondary-text">Room 210</span>', 'Monday' => '—', 'Tuesday' => 'Data Structures<br><span class="text-xs text-secondary-text">Room 118</span>', 'Wednesday' => '—', 'Thursday' => 'Project Lab<br><span class="text-xs text-secondary-text">Lab 1</span>'],
            ['time' => '10:30 - 11:20', 'Saturday' => 'Programming Lab<br><span class="text-xs text-secondary-text">Lab 3</span>', 'Sunday' => '—', 'Monday' => 'Operating Systems<br><span class="text-xs text-secondary-text">Room 401</span>', 'Tuesday' => '—', 'Wednesday' => '—', 'Thursday' => '—'],
        ];
    @endphp

    <div class="space-y-6">
        <section class="rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card flex items-center justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">Routines</p>
                <h1 class="mt-1 text-2xl font-bold text-main-text">Weekly schedule</h1>
            </div>
            <div>
                <button class="inline-flex items-center gap-2 rounded-[10px] bg-[#3B5BDB] px-4 py-2 text-sm font-bold text-white">Create Routine</button>
            </div>
        </section>

        <x-card class="overflow-hidden rounded-xl">
            <div class="-m-6 overflow-x-auto">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-[#3B5BDB] text-white">
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">Time</th>
                            @foreach ($days as $day)
                                <th class="px-4 py-4 text-left font-bold uppercase tracking-wide">{{ $day }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($routineRows as $row)
                            <tr class="border-b border-border-soft last:border-b-0 hover:bg-[#F8FBFF]">
                                <td class="whitespace-nowrap px-4 py-4 font-semibold text-main-text">{{ $row['time'] }}</td>
                                @foreach ($days as $day)
                                    <td class="px-4 py-4 align-top text-secondary-text">{!! $row[$day] !!}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
@endsection
