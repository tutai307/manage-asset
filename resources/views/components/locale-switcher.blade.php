<div role="group" aria-label="{{ __('common.language') }}" {{ $attributes->class('inline-flex rounded-lg border border-line p-0.5') }}>
    @foreach (App\Enums\AppLocale::cases() as $locale)
        @php($active = App\Enums\AppLocale::current() === $locale)
        <form method="POST" action="{{ route('locale.switch', $locale->value) }}">
            @csrf
            <button type="submit" lang="{{ $locale->value }}" title="{{ $locale->label() }}" aria-pressed="{{ $active ? 'true' : 'false' }}"
                @class([
                    'rounded-md px-2 py-0.5 text-xs transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600',
                    'bg-brand-600 font-semibold text-white' => $active,
                    'font-medium text-ink-subtle hover:text-ink' => ! $active,
                ])>
                {{ $locale->shortLabel() }}
            </button>
        </form>
    @endforeach
</div>
