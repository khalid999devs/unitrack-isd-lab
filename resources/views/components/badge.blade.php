@props([
    'type' => 'default',
    'variant' => 'default',
])

@php
    $classes = match($variant) {
        'student' => 'bg-role-student-bg text-role-student-text',
        'teacher' => 'bg-role-teacher-bg text-role-teacher-text',
        'admin' => 'bg-role-admin-bg text-role-admin-text',
        'success' => 'bg-success-bg text-success-text',
        'error' => 'bg-error-bg text-error-text',
        'warning' => 'bg-warning-bg text-warning-text',
        'info' => 'bg-info-bg text-info-text',
        default => 'bg-muted-bg text-secondary-text',
    };

    $baseClasses = $classes . ' inline-flex items-center rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wide';
@endphp

<span {{ $attributes->merge(['class' => $baseClasses]) }}>
    {{ $slot }}
</span>
