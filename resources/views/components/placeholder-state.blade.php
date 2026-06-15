@props([
    'icon' => 'layout-dashboard',
    'title' => '',
    'subtitle' => 'This section is under development. Content will appear here soon.',
])

<div class="flex min-h-[calc(100vh-11rem)] items-center justify-center py-6">
    <section class="w-full max-w-2xl rounded-2xl border border-border-soft bg-card-bg p-8 text-center shadow-[0_4px_16px_rgba(59,91,219,0.10)]">
        <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-2xl bg-blue-100 text-[#3B5BDB]">
            <i class="ti ti-{{ $icon }} text-[28px]"></i>
        </div>
        <h2 class="text-2xl font-bold text-main-text">{{ $title }}</h2>
        <p class="mt-3 text-sm leading-6 text-secondary-text">{{ $subtitle }}</p>
    </section>
</div>
