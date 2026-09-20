<div class="space-y-8">
    <header class="flex flex-wrap items-end justify-between gap-4 border-b border-line pb-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">{{ __('curriculum.title') }}</h1>
            <p class="mt-1 text-sm text-ink-muted">{{ __('curriculum.subtitle') }}</p>
        </div>

        @if ($canChooseGrade)
            <div role="group" aria-label="{{ __('curriculum.choose_grade') }}" class="inline-flex rounded-lg border border-line p-0.5">
                @foreach ($grades as $g)
                    <button type="button" wire:click="setGrade({{ $g }})" aria-pressed="{{ (int) $grade === $g ? 'true' : 'false' }}"
                        @class([
                            'rounded-md px-3 py-1.5 text-sm transition',
                            'bg-brand-600 font-semibold text-white' => (int) $grade === $g,
                            'font-medium text-ink-muted hover:text-ink' => (int) $grade !== $g,
                        ])>
                        {{ __('curriculum.grade_short', ['grade' => $g]) }}
                    </button>
                @endforeach
            </div>
        @else
            <p class="rounded-lg bg-brand-50 px-3 py-1.5 text-sm font-medium text-brand-700">{{ __('curriculum.grade_n', ['grade' => $grade]) }}</p>
        @endif
    </header>

    @foreach ($units as $term => $termUnits)
        <section>
            <h2 class="label-eyebrow mb-3">{{ __('curriculum.term', ['term' => $term]) }}</h2>

            <ul class="card divide-y divide-line">
                @foreach ($termUnits as $unit)
                    @php($count = $publishedOnly ? $unit->published_topics_count : $unit->published_topics_count + $unit->draft_topics_count)
                    <li wire:key="unit-{{ $unit->id }}">
                        <a href="{{ route('curriculum.show', $unit) }}" class="flex items-center gap-4 px-5 py-4 transition hover:bg-ground">
                            <span class="grid size-10 shrink-0 place-items-center rounded-lg bg-ground text-xl" aria-hidden="true">{{ $unit->emoji }}</span>

                            <div class="min-w-0 flex-1">
                                <p class="flex flex-wrap items-baseline gap-x-2">
                                    <span class="text-xs font-semibold text-ink-subtle tabular-nums">{{ $unit->label() }}</span>
                                    <span class="font-medium">{{ $unit->title() }}</span>
                                    {{-- The book prints the English title, so keep it visible for matching. --}}
                                    @if ($unit->title() !== $unit->title_en)
                                        <span lang="en" class="text-sm text-ink-subtle">{{ $unit->title_en }}</span>
                                    @endif
                                </p>
                                <p class="truncate text-sm text-ink-subtle">{{ $unit->focus() }}</p>
                            </div>

                            @if ($count > 0)
                                <span class="hidden shrink-0 rounded-full bg-good-soft px-2.5 py-0.5 text-xs font-medium text-good sm:inline-block">
                                    {{ trans_choice('curriculum.lesson_count', $count, ['count' => $count]) }}
                                </span>
                            @else
                                <span class="hidden shrink-0 rounded-full border border-line px-2.5 py-0.5 text-xs font-medium text-ink-subtle sm:inline-block">
                                    {{ __('curriculum.no_lessons_yet') }}
                                </span>
                            @endif

                            <x-icon name="arrow-right" class="size-4 text-ink-subtle" />
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
    @endforeach
</div>
