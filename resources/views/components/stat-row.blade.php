@props(['stats'])

{{-- One bordered strip divided into cells, rather than a row of competing cards. --}}
<dl {{ $attributes->class('card grid grid-cols-2 divide-line sm:grid-cols-4 sm:divide-x') }}>
    @foreach ($stats as $stat)
        <div class="flex flex-col gap-1 px-5 py-4">
            <dt class="text-sm text-ink-muted">{{ $stat['label'] }}</dt>
            <dd class="flex items-baseline gap-1.5">
                <span class="text-2xl font-bold tabular-nums">{{ $stat['value'] }}</span>
                @isset($stat['suffix'])
                    <span class="text-sm text-ink-subtle tabular-nums">{{ $stat['suffix'] }}</span>
                @endisset
            </dd>
        </div>
    @endforeach
</dl>
