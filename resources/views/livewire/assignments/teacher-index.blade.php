<div class="space-y-6">
    <header class="flex flex-wrap items-end justify-between gap-3 border-b border-line pb-5">
        <h1 class="text-2xl font-bold tracking-tight">{{ __('assignments.teacher_title') }}</h1>
        <a href="{{ route('exercises.create') }}" class="btn-primary"><x-icon name="plus" class="size-4" /> {{ __('skills.new_exercise') }}</a>
    </header>

    @if ($assignments->isEmpty())
        <p class="card p-8 text-center text-sm text-ink-muted">{{ __('assignments.empty_teacher') }}</p>
    @else
        <ul class="card divide-y divide-line">
            @foreach ($assignments as $assignment)
                @php($done = (int) $assignment->students_done)
                @php($total = (int) $assignment->students_total)
                <li wire:key="assignment-{{ $assignment->id }}" class="flex flex-wrap items-center gap-4 px-5 py-4">
                    <x-icon :name="$assignment->exercise->skill->icon()" class="text-brand-600" />
                    <div class="min-w-0 flex-1">
                        <a href="{{ route('assignments.show', $assignment) }}" class="font-medium hover:underline">{{ $assignment->exercise->title() }}</a>
                        <p class="text-sm text-ink-subtle">
                            {{ $assignment->classroom->name }} ·
                            <span @class(['text-bad' => $assignment->isOverdue()])>
                                {{ $assignment->due_at ? __('assignments.due_on', ['date' => $assignment->due_at->setTimezone(config('app.display_timezone'))->format('d/m/Y H:i')]) : __('assignments.no_due') }}
                            </span>
                        </p>
                    </div>
                    <div class="w-40">
                        <p class="text-right text-sm tabular-nums">{{ __('assignments.completed', ['done' => $done, 'total' => $total]) }}</p>
                        <div class="mt-1 h-1.5 rounded-full bg-ground" aria-hidden="true">
                            <div class="h-full rounded-full bg-good" style="width: {{ $total ? round($done / $total * 100) : 0 }}%"></div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

        {{ $assignments->links() }}
    @endif
</div>
