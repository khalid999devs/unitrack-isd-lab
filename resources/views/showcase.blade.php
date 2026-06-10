@php
    $role = 'admin';
    $title = 'Components Showcase';
    $active = 'dashboard';

    $sampleStudents = [
        ['id' => 'STU001', 'name' => 'Ahmed Ali', 'email' => 'ahmed@example.com', 'department' => 'CS', 'status' => 'Active'],
        ['id' => 'STU002', 'name' => 'Fatima Khan', 'email' => 'fatima@example.com', 'department' => 'EEE', 'status' => 'Active'],
        ['id' => 'STU003', 'name' => 'Karim Hassan', 'email' => 'karim@example.com', 'department' => 'CE', 'status' => 'Inactive'],
    ];
@endphp

@extends('layouts.app')

@section('title', 'Components Showcase - UniTrack')

@section('content')
    <div class="space-y-8">
        <!-- Form Inputs Showcase -->
        <section class="space-y-4">
            <h2 class="text-2xl font-bold text-main-text">Form Inputs</h2>

            <x-form-group title="Text Inputs" description="Basic form input examples">
                <x-form-input
                    name="example_text"
                    label="Text Input"
                    placeholder="Enter text..."
                    hint="This is a helper text"
                />

                <x-form-input
                    name="example_email"
                    type="email"
                    label="Email Input"
                    placeholder="example@domain.com"
                    required
                />

                <x-form-input
                    name="example_password"
                    type="password"
                    label="Password Input"
                    placeholder="••••••••"
                    required
                    error="Password is too weak"
                />
            </x-form-group>

            <x-form-group title="Textarea & Select" description="Complex input types">
                <x-form-input
                    name="example_textarea"
                    type="textarea"
                    label="Textarea Input"
                    placeholder="Enter description..."
                    hint="Maximum 500 characters"
                />

                <x-form-input
                    name="example_select"
                    type="select"
                    label="Select Dropdown"
                    required
                >
                    <option value="">Select an option</option>
                    <option value="1">Option 1</option>
                    <option value="2">Option 2</option>
                </x-form-input>
            </x-form-group>
        </section>

        <!-- Badges Showcase -->
        <section class="space-y-4">
            <h2 class="text-2xl font-bold text-main-text">Badges</h2>

            <x-card title="Role Badges">
                <div class="flex flex-wrap gap-3">
                    <x-badge variant="student">Student</x-badge>
                    <x-badge variant="teacher">Teacher</x-badge>
                    <x-badge variant="admin">Admin</x-badge>
                </div>
            </x-card>

            <x-card title="Status Badges">
                <div class="flex flex-wrap gap-3">
                    <x-badge variant="success">Completed</x-badge>
                    <x-badge variant="warning">Pending</x-badge>
                    <x-badge variant="error">Failed</x-badge>
                    <x-badge variant="info">Draft</x-badge>
                </div>
            </x-card>

            <x-card title="Badge List Component">
                <x-badge-list :items="[
                    ['label' => 'Computer Science', 'variant' => 'info'],
                    ['label' => 'Semester 5', 'variant' => 'success'],
                    ['label' => 'Active', 'variant' => 'success'],
                ]" />
            </x-card>
        </section>

        <!-- Buttons Showcase -->
        <section class="space-y-4">
            <h2 class="text-2xl font-bold text-main-text">Buttons</h2>

            <x-card title="Button Variants">
                <div class="flex flex-wrap gap-3">
                    <x-button>Primary Button</x-button>
                    <x-button variant="secondary">Secondary Button</x-button>
                    <x-button variant="danger">Danger Button</x-button>
                </div>
            </x-card>
        </section>

        <!-- Table Showcase -->
        <section class="space-y-4">
            <h2 class="text-2xl font-bold text-main-text">Data Table</h2>

            <x-table
                :headers="['Student ID', 'Name', 'Email', 'Department', 'Status']"
                emptyMessage="No students available"
            >
                @foreach ($sampleStudents as $student)
                    <tr>
                        <td class="px-4 py-3 text-sm font-medium text-main-text">{{ $student['id'] }}</td>
                        <td class="px-4 py-3 text-sm text-main-text">{{ $student['name'] }}</td>
                        <td class="px-4 py-3 text-sm text-secondary-text">{{ $student['email'] }}</td>
                        <td class="px-4 py-3 text-sm text-main-text">{{ $student['department'] }}</td>
                        <td class="px-4 py-3 text-sm">
                            <x-badge variant="{{ $student['status'] === 'Active' ? 'success' : 'warning' }}">
                                {{ $student['status'] }}
                            </x-badge>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </section>

        <!-- Empty State Showcase -->
        <section class="space-y-4">
            <h2 class="text-2xl font-bold text-main-text">Empty States</h2>

            <x-empty-state
                icon="📚"
                title="No Courses Enrolled"
                message="You don't have any courses assigned yet. Please contact your admin."
            >
                <x-button href="#" variant="secondary" class="mt-4">Browse Courses</x-button>
            </x-empty-state>
        </section>

        <!-- Alerts Showcase -->
        <section class="space-y-4">
            <h2 class="text-2xl font-bold text-main-text">Alerts</h2>

            <x-alert type="success">
                ✓ Success! Your changes have been saved successfully.
            </x-alert>

            <x-alert type="error">
                ✗ Error! Something went wrong. Please try again.
            </x-alert>

            <x-alert type="warning">
                ⚠ Warning! Your session will expire in 5 minutes.
            </x-alert>

            <x-alert type="info">
                ℹ Info: This is an informational message for the user.
            </x-alert>
        </section>

        <!-- Modal & Spinner Showcase -->
        <section class="space-y-4">
            <h2 class="text-2xl font-bold text-main-text">Other Components</h2>

            <x-card title="Loading Spinner Sizes">
                <div class="flex gap-8">
                    <div class="flex items-center gap-2">
                        <x-spinner size="sm" />
                        <span class="text-sm text-secondary-text">Small</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <x-spinner size="md" />
                        <span class="text-sm text-secondary-text">Medium</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <x-spinner size="lg" />
                        <span class="text-sm text-secondary-text">Large</span>
                    </div>
                </div>
            </x-card>

            <x-card title="Modal Example">
                <p class="text-sm text-secondary-text mb-4">
                    Click the button below to open a confirmation modal. The modal component is hidden by default and shown via JavaScript.
                </p>
                <button
                    type="button"
                    onclick="document.getElementById('exampleModal').classList.remove('hidden')"
                    class="bg-primary-blue text-on-primary hover:bg-royal-blue rounded-[10px] px-4 py-2 text-sm font-bold transition"
                >
                    Open Modal
                </button>
            </x-card>
        </section>

        <!-- Form Group Example -->
        <section class="space-y-4">
            <h2 class="text-2xl font-bold text-main-text">Complete Form Example</h2>

            <x-form-group title="Create New Student" description="Fill in all required fields">
                <form>
                    <x-form-input
                        name="student_id"
                        label="Student ID"
                        placeholder="STU001"
                        required
                    />

                    <x-form-input
                        name="name"
                        label="Full Name"
                        placeholder="John Doe"
                        required
                    />

                    <x-form-input
                        name="email"
                        type="email"
                        label="Email Address"
                        placeholder="john@example.com"
                        required
                    />

                    <x-form-input
                        name="department"
                        type="select"
                        label="Department"
                        required
                    >
                        <option value="">Select Department</option>
                        <option value="cs">Computer Science</option>
                        <option value="eee">Electrical Engineering</option>
                        <option value="ce">Civil Engineering</option>
                    </x-form-input>

                    <div class="mt-6 flex gap-3">
                        <x-button type="button">Create Student</x-button>
                        <x-button variant="secondary" type="button">Cancel</x-button>
                    </div>
                </form>
            </x-form-group>
        </section>
    </div>

    <!-- Hidden Modal -->
    <x-modal
        id="exampleModal"
        title="Confirm Action"
        message="Are you sure you want to proceed with this action? This cannot be undone."
        confirmText="Confirm"
        cancelText="Cancel"
        confirmAction="#"
    />
@endsection
