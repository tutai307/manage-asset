<div class="space-y-6">
    <header class="border-b border-line pb-5">
        <h1 class="text-2xl font-bold tracking-tight">{{ __('assignments.student_title') }}</h1>
    </header>

    @if ($assignments->isEmpty())
        <p class="card p-8 text-center text-sm text-ink-muted">{{ __('assignments.empty_student') }}</p>
    @else
        <ul class="card divide-y divide-line">
            @foreach ($assignments as $assignment)
                @php($done = $assignment->my_attempts > 0)
                <li wire:key="assignment-{{ $assignment->id }}" class="flex flex-wrap items-center gap-4 px-5 py-4">
                    <x-icon :name="$assignment->exercise->skill->icon()" class="text-brand-600" />
                    <div class="min-w-0 flex-1">
                        <p class="font-medium">{{ $assignment->exercise->title() }}</p>
                        <p class="text-sm text-ink-subtle">
                            {{ $assignment->exercise->skill->label() }} ·
                            <span @class(['font-medium text-bad' => ! $done && $assignment->isOverdue()])>
                                {{ $assignment->due_at ? __('assignments.due_on', ['date' => $assignment->due_at->setTimezone(config('app.display_timezone'))->format('d/m/Y H:i')]) : __('assignments.no_due') }}
                            </span>
                        </p>
                    </div>

                    @if ($done)
                        <span class="rounded-full bg-good-soft px-2.5 py-0.5 text-xs font-medium text-good">
                            {{ __('assignments.done') }} · {{ $assignment->my_best }}/{{ $assignment->my_max }}
                        </span>
                    @elseif ($assignment->isOverdue())
                        <span class="rounded-full bg-bad-soft px-2.5 py-0.5 text-xs font-medium text-bad">{{ __('assignments.overdue') }}</span>
                    @else
                        <span class="rounded-full bg-warn-soft px-2.5 py-0.5 text-xs font-medium">{{ __('assignments.not_done') }}</span>
                    @endif

                    <a href="{{ route('exercises.show', $assignment->exercise) }}" @class(['btn-primary' => ! $done, 'btn-secondary' => $done])>
                        {{ $done ? __('assignments.review') : __('assignments.open') }}
                    </a>
                </li>
            @endforeach
        </ul>

        {{ $assignments->links() }}
    @endif
</div>
