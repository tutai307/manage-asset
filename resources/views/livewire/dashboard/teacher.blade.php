<div class="space-y-10">
    <header class="flex flex-wrap items-end justify-between gap-4 border-b border-line pb-6">
        <div>
            <p class="text-sm text-ink-muted">{{ __('dashboard.hello') }}</p>
            <h1 class="text-2xl font-bold tracking-tight">{{ auth()->user()->name }}</h1>
            <p class="mt-1 text-sm text-ink-muted">{{ __('dashboard.teacher_intro') }}</p>
        </div>
        <a href="{{ route('classrooms.index') }}" class="btn-primary">
            <x-icon name="plus" class="size-4" /> {{ __('classrooms.create') }}
        </a>
    </header>

    <section aria-label="{{ __('dashboard.overview') }}">
        <x-stat-row :stats="[
            ['label' => __('dashboard.stat_classes'), 'value' => $stats['classes']],
            ['label' => __('dashboard.stat_students'), 'value' => $stats['students']],
            ['label' => __('dashboard.stat_roleplays_week'), 'value' => $stats['roleplays_week']],
            ['label' => __('dashboard.stat_active_week'), 'value' => $stats['active_week']],
        ]" />
    </section>

    <div class="grid gap-10 lg:grid-cols-5">
        <section class="lg:col-span-3">
            <h2 class="mb-3 text-lg font-semibold">{{ __('dashboard.recent_activity') }}</h2>

            @if ($recentActivity->isEmpty())
                <div class="card p-8 text-center">
                    <p class="font-medium">{{ __('dashboard.no_activity') }}</p>
                    <p class="mt-1 text-sm text-ink-muted">{{ __('dashboard.no_activity_hint') }}</p>
                </div>
            @else
                <ul class="card divide-y divide-line">
                    @foreach ($recentActivity as $conversation)
                        <li wire:key="activity-{{ $conversation->id }}" class="flex items-center gap-4 px-5 py-3.5">
                            <span class="grid size-9 shrink-0 place-items-center rounded-full bg-brand-50 text-sm font-semibold text-brand-700" aria-hidden="true">
                                {{ mb_strtoupper(mb_substr(Illuminate\Support\Str::afterLast($conversation->user->name, ' '), 0, 1)) }}
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm"><span class="font-medium">{{ $conversation->user->name }}</span> · {{ $conversation->scenario->title() }}</p>
                                <p class="truncate text-xs text-ink-subtle">
                                    {{ $conversation->scenario->topic->title() }} ·
                                    {{ trans_choice('dashboard.turns', $conversation->student_turns, ['count' => $conversation->student_turns]) }}
                                </p>
                            </div>
                            <time class="shrink-0 text-xs text-ink-subtle" datetime="{{ $conversation->updated_at->toIso8601String() }}">
                                {{ $conversation->updated_at->locale(app()->getLocale())->diffForHumans(short: true) }}
                            </time>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <section class="lg:col-span-2 space-y-6">
            <div>
                <div class="mb-3 flex items-baseline justify-between gap-4">
                    <h2 class="text-lg font-semibold">{{ __('classrooms.title') }}</h2>
                    <a href="{{ route('classrooms.index') }}" class="btn-quiet">{{ __('dashboard.see_all') }}</a>
                </div>

                @if ($classrooms->isEmpty())
                    <p class="card p-6 text-sm text-ink-muted">{{ __('classrooms.empty') }}</p>
                @else
                    <ul class="card divide-y divide-line">
                        @foreach ($classrooms as $classroom)
                            <li wire:key="class-{{ $classroom->id }}">
                                <a href="{{ route('classrooms.show', $classroom) }}" class="flex items-center gap-4 px-5 py-3.5 transition hover:bg-ground">
                                    <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-ground text-sm font-semibold">{{ $classroom->name }}</span>
                                    <p class="flex-1 text-sm text-ink-muted">{{ trans_choice('classrooms.student_total', $classroom->students_count, ['count' => $classroom->students_count]) }}</p>
                                    <x-icon name="arrow-right" class="size-4 text-ink-subtle" />
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <a href="{{ route('topics.index') }}" class="card flex items-center gap-4 px-5 py-4 transition hover:bg-ground">
                <x-icon name="book" class="text-brand-600" />
                <div class="flex-1">
                    <p class="font-medium">{{ __('dashboard.topic_library') }}</p>
                    <p class="text-sm text-ink-subtle">{{ trans_choice('dashboard.published_topics', $publishedTopics, ['count' => $publishedTopics]) }}</p>
                </div>
                <x-icon name="arrow-right" class="size-4 text-ink-subtle" />
            </a>
        </section>
    </div>
</div>
