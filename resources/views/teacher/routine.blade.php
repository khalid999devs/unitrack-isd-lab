@php
    $role = 'teacher';
    $title = 'Routine';
    $active = 'routine';
@endphp

@extends('layouts.app')

@section('title', 'Routine - UniTrack')

@section('content')
    @php
        $days = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'];
        $routineRows = [
            ['time' => '08:30 - 09:20', 'Saturday' => 'Database Systems<br><span class="text-xs text-secondary-text">Room 402</span>', 'Sunday' => '—', 'Monday' => 'Web Application<br><span class="text-xs text-secondary-text">Room 305</span>', 'Tuesday' => '—', 'Wednesday' => 'Office Hour<br><span class="text-xs text-secondary-text">Room 101</span>', 'Thursday' => '—'],
            ['time' => '09:30 - 10:20', 'Saturday' => '—', 'Sunday' => 'Lab Supervision<br><span class="text-xs text-secondary-text">Lab 2</span>', 'Monday' => '—', 'Tuesday' => 'Software Architecture<br><span class="text-xs text-secondary-text">Room 118</span>', 'Wednesday' => '—', 'Thursday' => 'Project Review<br><span class="text-xs text-secondary-text">Room 201</span>'],
            ['time' => '10:30 - 11:20', 'Saturday' => 'Programming Lab<br><span class="text-xs text-secondary-text">Lab 3</span>', 'Sunday' => '—', 'Monday' => 'Operating Systems<br><span class="text-xs text-secondary-text">Room 401</span>', 'Tuesday' => '—', 'Wednesday' => '—', 'Thursday' => '—'],
            ['time' => '01:30 - 02:20', 'Saturday' => '—', 'Sunday' => 'Discrete Math<br><span class="text-xs text-secondary-text">Room 115</span>', 'Monday' => '—', 'Tuesday' => 'Database Tutorial<br><span class="text-xs text-secondary-text">Room 402</span>', 'Wednesday' => '—', 'Thursday' => '—'],
        ];
    @endphp

    <div class="space-y-6">
        <section class="rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card">
            <div class="flex flex-col gap-2">
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">Weekly Routine</p>
                <h1 class="text-2xl font-bold text-main-text">Your teaching schedule</h1>
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
