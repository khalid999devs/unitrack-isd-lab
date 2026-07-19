@php
    $role = 'admin';
    $title = 'Registration Requests';
    $active = 'registration-requests';
    $statusOptions = [
        'pending' => 'Pending',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
        'all' => 'All',
    ];
@endphp

@extends('layouts.app')

@section('title', 'Registration Requests - UniTrack')

@section('content')
    <div class="space-y-6">
        <section class="flex flex-col gap-4 rounded-2xl border border-border-soft bg-card-bg p-5 shadow-card sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-bold text-main-text">Access approval queue</p>
                <p class="text-sm text-secondary-text">Review student and teacher registration requests before accounts are created.</p>
            </div>
            <div class="grid grid-cols-3 gap-2 text-center">
                <div class="rounded-xl bg-warning-bg px-4 py-3">
                    <p class="text-lg font-black text-warning-text">{{ $counts['pending'] }}</p>
                    <p class="text-[11px] font-bold uppercase tracking-wide text-warning-text">Pending</p>
                </div>
                <div class="rounded-xl bg-success-bg px-4 py-3">
                    <p class="text-lg font-black text-success-text">{{ $counts['approved'] }}</p>
                    <p class="text-[11px] font-bold uppercase tracking-wide text-success-text">Approved</p>
                </div>
                <div class="rounded-xl bg-error-bg px-4 py-3">
                    <p class="text-lg font-black text-error-text">{{ $counts['rejected'] }}</p>
                    <p class="text-[11px] font-bold uppercase tracking-wide text-error-text">Rejected</p>
                </div>
            </div>
        </section>

        @if (session('success'))
            <x-alert type="success">
                {{ session('success') }}
            </x-alert>
        @endif

        @if ($errors->any())
            <x-alert type="error">
                {{ $errors->first() }}
            </x-alert>
        @endif

        <div class="rounded-xl border border-border-soft bg-card-bg p-4 shadow-card">
            <form method="GET" action="{{ route('admin.registration-requests') }}" class="grid gap-3 lg:grid-cols-[1fr_220px_auto]">
                <div class="relative">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search name, email, ID, or department..."
                        class="h-11 w-full rounded-[10px] border border-input-border pl-10 pr-4 text-sm outline-none transition placeholder:text-placeholder-text focus:border-primary-blue focus:ring-4 focus:ring-focus-ring"
                    >
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-secondary-text">
                        <i class="ti ti-search text-lg"></i>
                    </div>
                </div>

                <select
                    name="status"
                    class="h-11 rounded-[10px] border border-input-border bg-card-bg px-3 text-sm font-semibold outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring"
                >
                    @foreach ($statusOptions as $value => $label)
                        <option value="{{ $value }}" @selected($status === $value)>{{ $label }}</option>
                    @endforeach
                </select>

                <div class="flex gap-2">
                    <x-button type="submit">Filter</x-button>
                    @if (request('search') || $status !== 'pending')
                        <x-button variant="secondary" href="{{ route('admin.registration-requests') }}">Clear</x-button>
                    @endif
                </div>
            </form>
        </div>

        <x-table
            :headers="['Applicant', 'Role', 'Academic Details', 'Status', 'Requested', 'Actions']"
            emptyMessage="No registration requests found."
        >
            @foreach ($registrationRequests as $registrationRequest)
                @php
                    $statusVariant = match($registrationRequest->status) {
                        'approved' => 'success',
                        'rejected' => 'error',
                        default => 'warning',
                    };
                    $identifier = $registrationRequest->role === 'student'
                        ? $registrationRequest->student_id
                        : $registrationRequest->teacher_id;
                    $detailLine = $registrationRequest->role === 'student'
                        ? trim(($registrationRequest->semester ?? '').' / Batch '.($registrationRequest->batch ?? ''))
                        : ($registrationRequest->designation ?? 'Teacher');
                @endphp
                <tr class="border-b border-border-soft transition last:border-b-0 hover:bg-muted-bg">
                    <td class="px-4 py-4 text-sm">
                        <p class="font-bold text-main-text">{{ $registrationRequest->name }}</p>
                        <p class="text-xs text-secondary-text">{{ $registrationRequest->email }}</p>
                        @if ($registrationRequest->phone)
                            <p class="mt-1 text-xs text-secondary-text">{{ $registrationRequest->phone }}</p>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-sm">
                        <x-badge variant="{{ $registrationRequest->role }}">
                            {{ $registrationRequest->role }}
                        </x-badge>
                    </td>
                    <td class="px-4 py-4 text-sm">
                        <p class="font-semibold text-main-text">{{ $identifier }}</p>
                        <p class="text-xs text-secondary-text">{{ $registrationRequest->department }}</p>
                        <p class="text-xs text-secondary-text">{{ $detailLine }}</p>
                    </td>
                    <td class="px-4 py-4 text-sm">
                        <x-badge variant="{{ $statusVariant }}">
                            {{ $registrationRequest->status }}
                        </x-badge>
                        @if ($registrationRequest->reviewer)
                            <p class="mt-2 text-xs text-secondary-text">By {{ $registrationRequest->reviewer->name }}</p>
                        @endif
                        @if ($registrationRequest->rejection_reason)
                            <p class="mt-2 max-w-xs text-xs text-error-text">{{ $registrationRequest->rejection_reason }}</p>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-sm text-secondary-text">
                        {{ $registrationRequest->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-4 py-4 text-sm">
                        @if ($registrationRequest->status === 'pending')
                            <div class="flex min-w-[260px] flex-col gap-2">
                                <form method="POST" action="{{ route('admin.registration-requests.approve', $registrationRequest) }}">
                                    @csrf
                                    <button type="submit" class="inline-flex h-9 w-full items-center justify-center rounded-[10px] bg-success px-3 text-xs font-black uppercase tracking-wide text-on-primary transition hover:bg-success-text">
                                        <i class="ti ti-check mr-2 text-base"></i>
                                        Approve
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.registration-requests.reject', $registrationRequest) }}" class="grid gap-2 sm:grid-cols-[1fr_auto]">
                                    @csrf
                                    <input
                                        type="text"
                                        name="rejection_reason"
                                        placeholder="Reason"
                                        class="h-9 rounded-[10px] border border-input-border px-3 text-xs outline-none transition placeholder:text-placeholder-text focus:border-primary-blue focus:ring-4 focus:ring-focus-ring"
                                    >
                                    <button type="submit" class="inline-flex h-9 items-center justify-center rounded-[10px] border border-error-border bg-error-bg px-3 text-xs font-black uppercase tracking-wide text-error-text transition hover:bg-error hover:text-on-primary">
                                        Reject
                                    </button>
                                </form>
                            </div>
                        @else
                            <span class="text-xs font-semibold text-secondary-text">
                                Reviewed {{ $registrationRequest->reviewed_at?->format('M d, Y') ?? 'N/A' }}
                            </span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-table>

        @if ($registrationRequests->hasPages())
            <div>
                {{ $registrationRequests->links() }}
            </div>
        @endif
    </div>
@endsection
