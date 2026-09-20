<div class="space-y-6">
    <header class="flex flex-wrap items-end justify-between gap-4 border-b border-line pb-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">{{ __('topics.title') }}</h1>
            <p class="mt-1 text-sm text-ink-muted">{{ __('topics.subtitle') }}</p>
        </div>

        <div class="relative w-full sm:w-64">
            <label for="topic-search" class="sr-only">{{ __('topics.search') }}</label>
            <x-icon name="search" class="pointer-events-none absolute top-1/2 left-3 size-4.5 -translate-y-1/2 text-ink-subtle" />
            <input wire:model.live.debounce.400ms="search" id="topic-search" type="search" placeholder="{{ __('topics.search') }}" class="form-input pl-10">
        </div>
    </header>

    <ul class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3" wire:loading.class="opacity-60">
        @forelse ($topics as $topic)
            @php($done = $topic->roleplay_scenarios_count > 0 && $topic->practised_scenarios_count >= $topic->roleplay_scenarios_count)
            @php($progress = $topic->roleplay_scenarios_count > 0 ? round($topic->practised_scenarios_count / $topic->roleplay_scenarios_count * 100) : 0)
            <li wire:key="topic-{{ $topic->id }}">
                <a href="{{ route('topics.show', $topic) }}" class="card flex h-full flex-col p-5 transition hover:border-brand-200 hover:bg-surface focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600">
                    <div class="flex items-start justify-between gap-3">
                        <span class="text-2xl" aria-hidden="true">{{ $topic->emoji }}</span>
                        @unless ($topic->status->isVisibleToStudents())
                            <span class="rounded-full border border-line px-2 py-0.5 text-xs font-medium text-ink-muted">{{ $topic->status->label() }}</span>
                        @endunless
                        @if ($done)
                            <span class="rounded-full bg-good-soft px-2 py-0.5 text-xs font-medium text-good">{{ __('topics.completed') }}</span>
                        @endif
                    </div>

                    <h2 class="mt-3 font-semibold text-pretty">{{ $topic->title() }}</h2>
                    @if ($topic->title() !== $topic->title_en)
                        <p lang="en" class="text-sm text-ink-subtle">{{ $topic->title_en }}</p>
                    @endif

                    <p class="mt-2 text-sm text-ink-muted">
                        {{ trans_choice('topics.pattern_count', $topic->sentence_patterns_count, ['count' => $topic->sentence_patterns_count]) }}
                        ·
                        {{ trans_choice('topics.scenario_count', $topic->roleplay_scenarios_count, ['count' => $topic->roleplay_scenarios_count]) }}
                    </p>

                    <div class="mt-auto pt-5">
                        <div class="flex items-center justify-between text-xs text-ink-subtle">
                            <span>{{ __('topics.progress') }}</span>
                            <span class="tabular-nums">{{ $topic->practised_scenarios_count }}/{{ $topic->roleplay_scenarios_count }}</span>
                        </div>
                        <div class="mt-1.5 h-1.5 overflow-hidden rounded-full bg-line" role="progressbar" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100" aria-label="{{ __('topics.progress') }}">
                            <div @class(['h-full rounded-full', 'bg-good' => $done, 'bg-brand-600' => ! $done]) style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                </a>
            </li>
        @empty
            <li class="card col-span-full p-10 text-center text-sm text-ink-muted">
                {{ $search !== '' ? __('topics.no_results') : __('topics.empty') }}
            </li>
        @endforelse
    </ul>

    {{ $topics->links() }}
</div>
