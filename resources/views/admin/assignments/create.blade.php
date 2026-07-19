@php
    $role = 'admin';
    $title = 'Create Assignment';
    $active = 'assignments';
@endphp

@extends('layouts.app')

@section('title', 'Create Assignment - UniTrack')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-4"><x-button href="{{ route('admin.assignments') }}" variant="secondary" class="h-9 px-3"><i class="ti ti-arrow-left" aria-hidden="true"></i> Back</x-button><div><h2 class="text-xl font-bold text-primary-navy">Create coursework</h2><p class="text-sm text-secondary-text">The assignment is attributed to the selected course's assigned teacher.</p></div></div>
        <x-form-group title="Assignment Details" description="Students in the course department and semester will receive this task.">
            <form method="POST" action="{{ route('admin.assignments.store') }}" class="space-y-4">
                @csrf
                <x-form-input type="select" name="course_id" label="Course" required :error="$errors->first('course_id')"><option value="">Select an assigned course</option>@foreach ($courses as $course)<option value="{{ $course->id }}" @selected((string) old('course_id') === (string) $course->id)>{{ $course->course_code }} - {{ $course->course_title }} ({{ $course->teacher->user->name }})</option>@endforeach</x-form-input>
                <x-form-input name="title" label="Assignment Title" required :value="old('title')" :error="$errors->first('title')" />
                <x-form-input type="textarea" name="description" label="Description" required :value="old('description')" :error="$errors->first('description')" />
                <x-form-input type="datetime-local" name="deadline" label="Deadline" required :value="old('deadline')" :error="$errors->first('deadline')" />
                <div class="flex gap-3 pt-3"><x-button type="submit">Create Assignment</x-button><x-button href="{{ route('admin.assignments') }}" variant="secondary">Cancel</x-button></div>
            </form>
        </x-form-group>
    </div>
@endsection
