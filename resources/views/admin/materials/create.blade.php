@php
    $role = 'admin';
    $title = 'Upload Material';
    $active = 'materials';
@endphp

@extends('layouts.app')

@section('title', 'Upload Material - UniTrack')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <x-button variant="secondary" href="{{ route('admin.materials') }}" class="h-9 px-3"><i class="ti ti-arrow-left" aria-hidden="true"></i> Back</x-button>
            <div>
                <h2 class="text-xl font-bold text-primary-navy">Upload a course resource</h2>
                <p class="text-sm text-secondary-text">The material is attributed to the selected course's assigned teacher.</p>
            </div>
        </div>

        <x-form-group title="Material Details" description="Accepted files: PDF, Word, PowerPoint, JPG, or PNG up to 10 MB.">
            <form method="POST" action="{{ route('admin.materials.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <x-form-input type="select" name="course_id" label="Course" required :error="$errors->first('course_id')">
                    <option value="">Select an assigned course</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" @selected((string) old('course_id') === (string) $course->id)>{{ $course->course_code }} - {{ $course->course_title }} ({{ $course->teacher->user->name }})</option>
                    @endforeach
                </x-form-input>
                <x-form-input name="title" label="Material Title" required :value="old('title')" :error="$errors->first('title')" />
                <x-form-input type="textarea" name="description" label="Description" :value="old('description')" :error="$errors->first('description')" />
                <div>
                    <label for="material_file" class="mb-2 block text-sm font-semibold text-main-text">Material File <span class="text-error">*</span></label>
                    <input id="material_file" name="material_file" type="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png" required class="block w-full rounded-[10px] border border-input-border bg-card-bg px-3 py-2 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-primary-blue file:px-4 file:py-2 file:text-sm file:font-bold file:text-on-primary focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                    @error('material_file')<p class="mt-1 text-xs font-medium text-error">{{ $message }}</p>@enderror
                </div>
                <div class="flex gap-3 pt-3">
                    <x-button type="submit">Upload Material</x-button>
                    <x-button href="{{ route('admin.materials') }}" variant="secondary">Cancel</x-button>
                </div>
            </form>
        </x-form-group>
    </div>
@endsection
