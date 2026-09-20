<div class="space-y-10">
    <header class="flex flex-wrap items-end justify-between gap-4 border-b border-line pb-6">
        <div>
            <p class="text-sm text-ink-muted">{{ __('dashboard.hello') }}</p>
            <h1 class="text-2xl font-bold tracking-tight">{{ auth()->user()->name }}</h1>
            <p class="mt-1 text-sm text-ink-muted">{{ __('dashboard.student_intro') }}</p>
        </div>

        @if ($streak > 0)
            <p class="flex items-center gap-2 rounded-lg bg-warn-soft px-3 py-2 text-sm font-medium text-ink">
                <x-icon name="fire" class="size-5 text-warn" />
                {{ trans_choice('dashboard.streak', $streak, ['count' => $streak]) }}
            </p>
        @endif
    </header>

    <section aria-label="{{ __('dashboard.your_progress') }}">
        <x-stat-row :stats="[
            ['label' => __('dashboard.stat_topics'), 'value' => $stats['topics'], 'suffix' => '/ ' . $totalTopics],
            ['label' => __('dashboard.stat_roleplays'), 'value' => $stats['roleplays']],
            ['label' => __('dashboard.stat_messages'), 'value' => $stats['messages']],
            ['label' => __('dashboard.stat_reveals'), 'value' => $stats['reveals']],
        ]" />
    </section>

    <div class="grid gap-10 lg:grid-cols-5">
        <section class="lg:col-span-3">
            <div class="mb-3 flex items-baseline justify-between gap-4">
                <h2 class="text-lg font-semibold">{{ __('dashboard.continue') }}</h2>
                <a href="{{ route('conversations.index') }}" class="btn-quiet">{{ __('dashboard.see_all') }}</a>
            </div>

            @if ($recentConversations->isEmpty())
                <div class="card p-8 text-center">
                    <p class="font-medium">{{ __('dashboard.no_conversations') }}</p>
                    <p class="mt-1 text-sm text-ink-muted">{{ __('dashboard.no_conversations_hint') }}</p>
                    <a href="{{ route('topics.index') }}" class="btn-primary mt-4">{{ __('dashboard.start_learning') }}</a>
                </div>
            @else
                <ul class="card divide-y divide-line">
                    @foreach ($recentConversations as $conversation)
                        @php($progress = min(100, round($conversation->student_turns / App\Models\Conversation::MAX_STUDENT_TURNS * 100)))
                        <li wire:key="recent-{{ $conversation->id }}">
                            <a href="{{ route('conversations.show', $conversation) }}" class="flex items-center gap-4 px-5 py-4 transition hover:bg-ground">
                                <span class="grid size-10 shrink-0 place-items-center rounded-lg bg-ground text-xl" aria-hidden="true">{{ $conversation->scenario->topic->emoji }}</span>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate font-medium">{{ $conversation->scenario->title() }}</p>
                                    <p class="truncate text-sm text-ink-subtle">
                                        {{ $conversation->scenario->topic->title() }} · {{ $conversation->updated_at->locale(app()->getLocale())->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="hidden w-28 sm:block">
                                    <div class="h-1.5 overflow-hidden rounded-full bg-line" role="progressbar" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100" aria-label="{{ __('roleplay.turns_label') }}">
                                        <div class="h-full rounded-full bg-brand-600" style="width: {{ $progress }}%"></div>
                                    </div>
                                    <p class="mt-1 text-right text-xs text-ink-subtle tabular-nums">{{ $conversation->student_turns }}/{{ App\Models\Conversation::MAX_STUDENT_TURNS }}</p>
                                </div>
                                <x-icon name="arrow-right" class="size-4 text-ink-subtle" />
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <section class="lg:col-span-2">
            <h2 class="mb-3 text-lg font-semibold">{{ __('dashboard.suggested') }}</h2>

            @if ($suggestedTopics->isEmpty())
                <p class="card p-6 text-sm text-ink-muted">{{ __('dashboard.all_topics_done') }}</p>
            @else
                <ul class="card divide-y divide-line">
                    @foreach ($suggestedTopics as $topic)
                        <li wire:key="suggested-{{ $topic->id }}">
                            <a href="{{ route('topics.show', $topic) }}" class="flex items-center gap-4 px-5 py-4 transition hover:bg-ground">
                                <span class="grid size-10 shrink-0 place-items-center rounded-lg bg-ground text-xl" aria-hidden="true">{{ $topic->emoji }}</span>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate font-medium">{{ $topic->title() }}</p>
                                    <p class="text-sm text-ink-subtle">{{ trans_choice('topics.pattern_count', $topic->sentence_patterns_count, ['count' => $topic->sentence_patterns_count]) }}</p>
                                </div>
                                <x-icon name="arrow-right" class="size-4 text-ink-subtle" />
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    </div>
</div>
