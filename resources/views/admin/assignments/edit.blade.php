@php
    $role = 'admin';
    $title = 'Edit Assignment';
    $active = 'assignments';
@endphp

@extends('layouts.app')

@section('title', 'Edit Assignment - UniTrack')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-4"><x-button href="{{ route('admin.assignments') }}" variant="secondary" class="h-9 px-3"><i class="ti ti-arrow-left" aria-hidden="true"></i> Back</x-button><div><h2 class="text-xl font-bold text-primary-navy">Edit coursework</h2><p class="text-sm text-secondary-text">Changes are reflected immediately on the Student assignment board.</p></div></div>
        <x-form-group title="Assignment Details" description="Keep the course, instructions, and deadline accurate.">
            <form method="POST" action="{{ route('admin.assignments.update', $assignment) }}" class="space-y-4">
                @csrf
                @method('PUT')
                <x-form-input type="select" name="course_id" label="Course" required :error="$errors->first('course_id')"><option value="">Select an assigned course</option>@foreach ($courses as $course)<option value="{{ $course->id }}" @selected((string) old('course_id', $assignment->course_id) === (string) $course->id)>{{ $course->course_code }} - {{ $course->course_title }} ({{ $course->teacher->user->name }})</option>@endforeach</x-form-input>
                <x-form-input name="title" label="Assignment Title" required :value="old('title', $assignment->title)" :error="$errors->first('title')" />
                <x-form-input type="textarea" name="description" label="Description" required :value="old('description', $assignment->description)" :error="$errors->first('description')" />
                <x-form-input type="datetime-local" name="deadline" label="Deadline" required :value="old('deadline', $assignment->deadline->format('Y-m-d\\TH:i'))" :error="$errors->first('deadline')" />
                <div class="flex gap-3 pt-3"><x-button type="submit">Save Changes</x-button><x-button href="{{ route('admin.assignments') }}" variant="secondary">Cancel</x-button></div>
            </form>
        </x-form-group>
    </div>
@endsection
