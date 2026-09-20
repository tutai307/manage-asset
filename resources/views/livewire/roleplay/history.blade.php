<div class="space-y-6">
    <header class="border-b border-line pb-6">
        <h1 class="text-2xl font-bold tracking-tight">{{ __('nav.conversations') }}</h1>
        <p class="mt-1 text-sm text-ink-muted">{{ trans_choice('history.subtitle', $conversations->total(), ['count' => $conversations->total()]) }}</p>
    </header>

    @if ($conversations->isEmpty())
        <div class="card p-10 text-center">
            <p class="font-medium">{{ __('dashboard.no_conversations') }}</p>
            <p class="mt-1 text-sm text-ink-muted">{{ __('dashboard.no_conversations_hint') }}</p>
            <a href="{{ route('topics.index') }}" class="btn-primary mt-4">{{ __('dashboard.start_learning') }}</a>
        </div>
    @else
        <ul class="card divide-y divide-line" wire:loading.class="opacity-60">
            @foreach ($conversations as $conversation)
                @php($turns = $conversation->student_turns)
                @php($done = $turns >= App\Models\Conversation::MAX_STUDENT_TURNS)
                <li wire:key="conversation-{{ $conversation->id }}">
                    <a href="{{ route('conversations.show', $conversation) }}" class="flex items-center gap-4 px-5 py-4 transition hover:bg-ground">
                        <span class="grid size-10 shrink-0 place-items-center rounded-lg bg-ground text-xl" aria-hidden="true">{{ $conversation->scenario->topic->emoji }}</span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate font-medium">{{ $conversation->scenario->title() }}</p>
                            <p class="truncate text-sm text-ink-subtle">
                                {{ $conversation->scenario->topic->title() }} ·
                                <time datetime="{{ $conversation->updated_at->toIso8601String() }}">{{ $conversation->updated_at->setTimezone(config('app.display_timezone'))->format('d/m/Y H:i') }}</time>
                            </p>
                        </div>
                        <span @class([
                            'hidden shrink-0 rounded-full px-2.5 py-0.5 text-xs font-medium sm:inline-block',
                            'bg-good-soft text-good' => $done,
                            'border border-line text-ink-muted' => ! $done,
                        ])>
                            {{ $done ? __('history.finished') : __('history.in_progress', ['used' => $turns, 'max' => App\Models\Conversation::MAX_STUDENT_TURNS]) }}
                        </span>
                        <x-icon name="arrow-right" class="size-4 text-ink-subtle" />
                    </a>
                </li>
            @endforeach
        </ul>

        {{ $conversations->links() }}
    @endif
</div>
