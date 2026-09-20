<div class="space-y-8">
    <a href="{{ route('topics.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-ink-muted transition hover:text-ink">
        <x-icon name="arrow-left" class="size-4" /> {{ __('topics.title') }}
    </a>

    <header class="flex items-start gap-4 border-b border-line pb-6">
        <span class="text-3xl" aria-hidden="true">{{ $topic->emoji }}</span>
        <div class="min-w-0">
            <h1 class="text-2xl font-bold tracking-tight">{{ $topic->title() }}</h1>
            @if ($topic->title() !== $topic->title_en)
                <p lang="en" class="text-sm text-ink-subtle">{{ $topic->title_en }}</p>
            @endif
            @if ($topic->description())
                <p class="mt-2 max-w-prose text-sm text-ink-muted">{{ $topic->description() }}</p>
            @endif
        </div>
    </header>

    <div class="grid gap-10 lg:grid-cols-5">
        <section class="lg:col-span-3">
            <div class="mb-3 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-lg font-semibold">{{ __('topics.patterns') }}</h2>

                <div role="group" aria-label="{{ __('topics.support.label') }}" class="inline-flex rounded-lg border border-line p-0.5">
                    @foreach ($levels as $level)
                        <button type="button" wire:click="setSupportLevel('{{ $level->value }}')"
                            aria-pressed="{{ $supportLevel === $level ? 'true' : 'false' }}"
                            @class([
                                'rounded-md px-3 py-1.5 text-sm transition',
                                'bg-brand-600 font-semibold text-white' => $supportLevel === $level,
                                'font-medium text-ink-muted hover:text-ink' => $supportLevel !== $level,
                            ])>
                            {{ $level->label() }}
                        </button>
                    @endforeach
                </div>
            </div>

            <ol class="card divide-y divide-line">
                @foreach ($topic->sentencePatterns as $pattern)
                    <li wire:key="pattern-{{ $pattern->id }}" class="flex items-start gap-3 px-4 py-3">
                        <button type="button" x-on:click="speakEnglish(@js($pattern->english))"
                            aria-label="{{ __('topics.listen', ['sentence' => $pattern->english]) }}"
                            class="mt-0.5 grid size-8 shrink-0 place-items-center rounded-lg text-ink-subtle transition hover:bg-brand-50 hover:text-brand-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600">
                            <x-icon name="speaker" class="size-4.5" />
                        </button>

                        <div class="min-w-0 flex-1">
                            <p lang="en" class="font-medium">{{ $pattern->english }}</p>

                            @if ($supportLevel === App\Enums\SupportLevel::Full || in_array($pattern->id, $revealed, true))
                                <p lang="vi" class="text-sm text-ink-muted">{{ $pattern->vietnamese }}</p>
                                @if ($pattern->note_vi)
                                    <p lang="vi" class="mt-1 text-xs text-ink-subtle">{{ $pattern->note_vi }}</p>
                                @endif
                            @else
                                @if ($supportLevel === App\Enums\SupportLevel::Partial)
                                    <p lang="vi" class="text-sm text-ink-subtle">{{ Illuminate\Support\Str::words($pattern->vietnamese, 2, ' …') }}</p>
                                @endif
                                <button type="button" wire:click="reveal({{ $pattern->id }})" class="mt-0.5 text-sm font-medium text-brand-700 transition hover:underline">
                                    {{ __('topics.reveal') }}
                                </button>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ol>
        </section>

        <section class="lg:col-span-2">
            <h2 class="text-lg font-semibold">{{ __('roleplay.title') }}</h2>
            <p class="mt-1 mb-3 text-sm text-ink-muted">{{ __('roleplay.intro') }}</p>

            <div class="space-y-4">
                @forelse ($topic->roleplayScenarios as $scenario)
                    <article wire:key="scenario-{{ $scenario->id }}" class="card p-5">
                        <h3 class="font-semibold">{{ $scenario->title() }}</h3>
                        @if ($scenario->title() !== $scenario->title_en)
                            <p lang="en" class="text-sm text-ink-subtle">{{ $scenario->title_en }}</p>
                        @endif
                        <p class="mt-2 text-sm text-ink-muted">{{ $scenario->situation() }}</p>
                        <button type="button" wire:click="startRoleplay({{ $scenario->id }})" wire:loading.attr="disabled" wire:target="startRoleplay" class="btn-primary mt-4 w-full">
                            {{ __('roleplay.start') }}
                        </button>
                    </article>
                @empty
                    <p class="card p-6 text-sm text-ink-muted">{{ __('roleplay.no_scenarios') }}</p>
                @endforelse
            </div>
        </section>
    </div>
</div>
