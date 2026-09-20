@props(['href', 'icon', 'active' => false])

<a href="{{ $href }}" @if ($active) aria-current="page" @endif
    @class([
        'group flex items-center gap-3 rounded-lg px-3 py-2 text-sm transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600',
        'bg-brand-50 font-semibold text-brand-700' => $active,
        'font-medium text-ink-muted hover:bg-ground hover:text-ink' => ! $active,
    ])>
    <x-icon :name="$icon" :class="$active ? 'text-brand-600' : 'text-ink-subtle group-hover:text-ink-muted'" />
    <span>{{ $slot }}</span>
</a>
