@php
    $role = 'teacher';
    $title = 'Edit Material';
    $active = 'materials';
@endphp

@extends('layouts.app')

@section('title', 'Edit Material - UniTrack')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <x-button variant="secondary" href="{{ route('teacher.materials') }}" class="h-9 px-3">
                <i class="ti ti-arrow-left text-base"></i>
                Back
            </x-button>
            <div>
                <h1 class="text-2xl font-bold text-primary-navy">Edit Material</h1>
                <p class="text-sm text-secondary-text">Update the study material details.</p>
            </div>
        </div>

        <x-form-group title="Material Details" description="Keep course resources clear and searchable.">
            <form method="POST" action="{{ route('teacher.materials.update', $material) }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <x-form-input type="select" name="course_id" label="Course" required :error="$errors->first('course_id')">
                    <option value="">Select course</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id', $material->course_id) == $course->id ? 'selected' : '' }}>
                            {{ $course->course_code }} - {{ $course->course_title }}
                        </option>
                    @endforeach
                </x-form-input>

                <x-form-input
                    name="title"
                    label="Material Title"
                    required
                    :value="old('title', $material->title)"
                    :error="$errors->first('title')"
                />

                <x-form-input
                    type="textarea"
                    name="description"
                    label="Description"
                    :value="old('description', $material->description)"
                    :error="$errors->first('description')"
                />

                <div>
                    <label for="material_file" class="mb-2 block text-sm font-semibold text-main-text">Replace File</label>
                    <input
                        id="material_file"
                        name="material_file"
                        type="file"
                        accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png"
                        class="block w-full rounded-[10px] border border-input-border bg-card-bg px-3 py-2 text-sm outline-none transition file:mr-4 file:rounded-lg file:border-0 file:bg-primary-blue file:px-4 file:py-2 file:text-sm file:font-bold file:text-on-primary focus:border-primary-blue focus:ring-4 focus:ring-focus-ring"
                    >
                    <p class="mt-1 text-xs text-secondary-text">
                        Current file: {{ $material->file_path ? basename($material->file_path) : 'No file attached' }}
                    </p>
                    @if ($errors->first('material_file'))
                        <p class="mt-1 text-xs font-medium text-error">{{ $errors->first('material_file') }}</p>
                    @endif
                </div>

                <div class="flex gap-3 pt-4">
                    <x-button type="submit">Save Changes</x-button>
                    <x-button variant="secondary" href="{{ route('teacher.materials') }}">Cancel</x-button>
                </div>
            </form>
        </x-form-group>
    </div>
@endsection
