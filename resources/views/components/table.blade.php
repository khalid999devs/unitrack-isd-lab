@props([
    'headers' => [],
    'rows' => [],
    'emptyMessage' => 'No data available',
    'hoverable' => true,
])

<div class="overflow-x-auto rounded-xl border border-border-soft bg-card-bg shadow-card">
    <table class="w-full border-collapse">
        @if (!empty($headers))
            <thead>
                <tr class="border-b border-border-soft bg-muted-bg">
                    @foreach ($headers as $header)
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-main-text">
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>
        @endif

        <tbody>
            @if (!empty($rows) && count($rows) > 0)
                @foreach ($rows as $row)
                    <tr class="{{ $hoverable ? 'hover:bg-muted-bg transition' : '' }} border-b border-border-soft last:border-b-0">
                        {{ $slot }}
                    </tr>
                @endforeach
            @elseif (!$slot->isEmpty())
                {{ $slot }}
            @else
                <tr>
                    <td colspan="{{ count($headers) ?: 1 }}" class="px-4 py-8 text-center text-sm text-secondary-text">
                        {{ $emptyMessage }}
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
