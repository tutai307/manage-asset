<section class="card p-5" aria-labelledby="assign-title">
    <h2 id="assign-title" class="font-semibold">{{ __('assignments.assign_title') }}</h2>
    <p class="mt-1 text-sm text-ink-muted">{{ __('assignments.assign_hint') }}</p>

    @if ($error)
        <p role="alert" class="mt-3 rounded-lg bg-bad-soft px-4 py-3 text-sm text-bad">{{ $error }}</p>
    @endif

    @if ($assignments->isNotEmpty())
        <div class="mt-4">
            <p class="label-eyebrow mb-2">{{ __('assignments.assigned_to') }}</p>
            <ul class="divide-y divide-line rounded-lg border border-line">
                @foreach ($assignments as $assignment)
                    <li wire:key="assignment-{{ $assignment->id }}" class="flex flex-wrap items-center gap-3 px-4 py-2.5 text-sm">
                        <span class="font-medium">{{ $assignment->classroom->name }}</span>
                        <span @class(['text-ink-subtle', 'text-bad' => $assignment->isOverdue()])>
                            {{ $assignment->due_at ? __('assignments.due_on', ['date' => $assignment->due_at->setTimezone(config('app.display_timezone'))->format('d/m/Y H:i')]) : __('assignments.no_due') }}
                        </span>
                        <span class="ml-auto flex gap-1">
                            <a href="{{ route('assignments.show', $assignment) }}" class="btn-quiet text-xs">{{ __('assignments.results') }}</a>
                            <button type="button" wire:click="unassign({{ $assignment->id }})"
                                wire:confirm="{{ __('assignments.unassign_confirm', ['class' => $assignment->classroom->name]) }}"
                                class="btn-quiet text-xs text-bad hover:bg-bad-soft">{{ __('assignments.unassign') }}</button>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($classrooms->isEmpty())
        <p class="mt-4 text-sm text-ink-muted">{{ __('assignments.no_classes') }}</p>
    @else
        <form wire:submit="assign" class="mt-4 space-y-4">
            <fieldset>
                <legend class="mb-2 text-sm font-medium">{{ __('assignments.classes') }}</legend>
                <div class="flex flex-wrap gap-2">
                    @foreach ($classrooms as $classroom)
                        <label wire:key="assign-class-{{ $classroom->id }}"
                            class="flex cursor-pointer items-center gap-2 rounded-lg border border-line px-3 py-2 text-sm transition hover:bg-ground has-checked:border-brand-600 has-checked:bg-brand-50">
                            <input type="checkbox" wire:model="classroomIds" value="{{ $classroom->id }}" class="size-4 rounded border-line-strong text-brand-600 focus:ring-brand-100">
                            {{ $classroom->name }}
                        </label>
                    @endforeach
                </div>
                @error('classroomIds') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
            </fieldset>

            <div class="sm:w-64">
                <label for="dueAt" class="mb-1.5 block text-sm font-medium">{{ __('assignments.due') }}</label>
                <input wire:model="dueAt" id="dueAt" type="datetime-local" class="form-input">
                @error('dueAt') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
            </div>

            <button type="submit" wire:loading.attr="disabled" wire:target="assign" class="btn-primary">
                <x-icon name="send" class="size-4" /> {{ __('assignments.assign') }}
            </button>
        </form>
    @endif
</section>
