<div class="space-y-6">
    <a href="{{ route('assignments.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-ink-muted transition hover:text-ink">
        <x-icon name="arrow-left" class="size-4" /> {{ __('assignments.teacher_title') }}
    </a>

    <header class="flex flex-wrap items-start justify-between gap-4 border-b border-line pb-5">
        <div>
            <p class="text-sm text-ink-muted">
                {{ $assignment->classroom->name }} ·
                <span @class(['text-bad' => $assignment->isOverdue()])>
                    {{ $assignment->due_at ? __('assignments.due_on', ['date' => $assignment->due_at->setTimezone(config('app.display_timezone'))->format('d/m/Y H:i')]) : __('assignments.no_due') }}
                </span>
            </p>
            <h1 class="mt-1 text-2xl font-bold tracking-tight">{{ $assignment->exercise->title() }}</h1>
            <a href="{{ route('exercises.show', $assignment->exercise) }}" class="btn-quiet mt-1 -ml-2.5">{{ __('skills.edit') }} / {{ __('assignments.assign') }}</a>
        </div>
        <dl class="flex gap-6 text-right">
            <div>
                <dt class="label-eyebrow">{{ __('assignments.done') }}</dt>
                <dd class="text-2xl font-bold tabular-nums">{{ $summary['done'] }}/{{ $total }}</dd>
            </div>
            <div>
                <dt class="label-eyebrow">{{ __('assignments.class_average') }}</dt>
                <dd class="text-2xl font-bold tabular-nums">{{ $summary['average'] ?? '—' }}</dd>
            </div>
        </dl>
    </header>

    <div class="card overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="border-b border-line bg-ground text-left text-xs text-ink-subtle">
                <tr>
                    <th scope="col" class="px-5 py-3 font-semibold">{{ __('assignments.student') }}</th>
                    <th scope="col" class="px-5 py-3 font-semibold">{{ __('assignments.best_score') }}</th>
                    <th scope="col" class="px-5 py-3 font-semibold">{{ __('assignments.attempts') }}</th>
                    <th scope="col" class="px-5 py-3 font-semibold">{{ __('assignments.last_attempt') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                @foreach ($students as $student)
                    @php($late = $student->first_at && $assignment->due_at && Illuminate\Support\Carbon::parse($student->first_at)->gt($assignment->due_at))
                    <tr wire:key="student-{{ $student->id }}">
                        <td class="px-5 py-3 font-medium">{{ $student->name }}</td>
                        <td class="px-5 py-3 tabular-nums">
                            @if ($student->attempts_count)
                                {{ $student->best_score }}/{{ $student->max_score }}
                                @if ($late)
                                    <span class="ml-1 rounded-full bg-warn-soft px-2 py-0.5 text-xs">{{ __('assignments.late') }}</span>
                                @endif
                            @else
                                <span class="text-ink-subtle">{{ __('assignments.not_done') }}</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 tabular-nums">{{ $student->attempts_count }}</td>
                        <td class="px-5 py-3 text-ink-muted tabular-nums">
                            {{ $student->last_at ? Illuminate\Support\Carbon::parse($student->last_at)->setTimezone(config('app.display_timezone'))->format('d/m/Y H:i') : '—' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $students->links() }}
</div>
