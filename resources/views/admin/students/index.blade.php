@php
    $role = 'admin';
    $title = 'Students Management';
    $active = 'students';
@endphp

@extends('layouts.app')

@section('title', 'Students Management - UniTrack')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-primary-navy">Students Management</h1>
                <p class="text-sm text-secondary-text">View and manage student profiles, accounts, and academic information.</p>
            </div>
            <div>
                <x-button href="{{ route('admin.students.create') }}">
                    <i class="ti ti-plus mr-2 text-base"></i> Add New Student
                </x-button>
            </div>
        </div>

        <!-- Success Alert -->
        @if (session('success'))
            <x-alert type="success">
                {{ session('success') }}
            </x-alert>
        @endif

        <!-- Search Filter Card -->
        <div class="rounded-xl border border-border-soft bg-card-bg p-4 shadow-card">
            <form method="GET" action="{{ route('admin.students') }}" class="flex flex-col gap-3 sm:flex-row">
                <div class="relative flex-1">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by name, student ID, or department..."
                        class="h-11 w-full rounded-[10px] border border-input-border pl-10 pr-4 text-sm outline-none transition placeholder:text-placeholder-text focus:border-primary-blue focus:ring-4 focus:ring-focus-ring"
                    >
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-secondary-text">
                        <i class="ti ti-search text-lg"></i>
                    </div>
                </div>
                <div class="flex gap-2">
                    <x-button type="submit">Search</x-button>
                    @if (request('search'))
                        <x-button variant="secondary" href="{{ route('admin.students') }}">Clear</x-button>
                    @endif
                </div>
            </form>
        </div>

        <!-- Students Table -->
        <x-table
            :headers="['Student ID', 'Name', 'Email', 'Department', 'Semester & Batch', 'Phone', 'Actions']"
            emptyMessage="No student records found."
        >
            @foreach ($students as $student)
                <tr class="hover:bg-muted-bg transition border-b border-border-soft last:border-b-0">
                    <td class="px-4 py-3.5 text-sm font-semibold text-main-text">{{ $student->student_id }}</td>
                    <td class="px-4 py-3.5 text-sm text-main-text">{{ $student->user->name }}</td>
                    <td class="px-4 py-3.5 text-sm text-secondary-text">{{ $student->user->email }}</td>
                    <td class="px-4 py-3.5 text-sm text-main-text">{{ $student->department }}</td>
                    <td class="px-4 py-3.5 text-sm text-main-text">
                        <div class="flex flex-col">
                            <span class="font-medium text-main-text">{{ $student->semester }}</span>
                            <span class="text-xs text-secondary-text">Batch {{ $student->batch }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3.5 text-sm text-secondary-text">{{ $student->phone ?? 'N/A' }}</td>
                    <td class="px-4 py-3.5 text-sm">
                        <div class="flex items-center gap-2">
                            <x-button variant="secondary" href="{{ route('admin.students.edit', $student) }}" class="h-9 px-3">
                                <i class="ti ti-edit text-base"></i>
                            </x-button>
                            
                            <button
                                type="button"
                                onclick="confirmDelete('{{ $student->id }}')"
                                class="inline-flex h-9 w-9 items-center justify-center rounded-[10px] bg-error/10 text-error hover:bg-error hover:text-white transition focus:outline-none focus:ring-4 focus:ring-red-100"
                            >
                                <i class="ti ti-trash text-base"></i>
                            </button>

                            <form id="delete-form-{{ $student->id }}" action="{{ route('admin.students.destroy', $student) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-table>

        <!-- Pagination -->
        @if ($students->hasPages())
            <div class="mt-6">
                {{ $students->links() }}
            </div>
        @endif
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this student record? This action will also delete the associated user account.')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@endsection
