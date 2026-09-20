<div class="space-y-8">
    <header class="border-b border-line pb-6">
        <h1 class="text-2xl font-bold tracking-tight">{{ __('classrooms.title') }}</h1>
        <p class="mt-1 text-sm text-ink-muted">{{ __('classrooms.subtitle') }}</p>
    </header>

    <section class="card p-5">
        <h2 class="font-semibold">{{ __('classrooms.create') }}</h2>

        <form wire:submit="create" class="mt-4 flex flex-wrap items-start gap-4">
            <div class="w-40">
                <label for="name" class="mb-1.5 block text-sm font-medium">{{ __('classrooms.name') }}</label>
                <input wire:model.blur="name" id="name" type="text" placeholder="7A" class="form-input">
                @error('name') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
            </div>

            <div class="w-36">
                <label for="grade" class="mb-1.5 block text-sm font-medium">{{ __('classrooms.grade') }}</label>
                <select wire:model="grade" id="grade" class="form-input">
                    <option value="">—</option>
                    @foreach (range(6, 9) as $g)
                        <option value="{{ $g }}">{{ __('classrooms.grade_n', ['grade' => $g]) }}</option>
                    @endforeach
                </select>
                @error('grade') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
            </div>

            <button type="submit" wire:loading.attr="disabled" wire:target="create" class="btn-primary mt-7">
                {{ __('classrooms.create_button') }}
            </button>
        </form>
    </section>

    <section>
        <h2 class="mb-3 text-lg font-semibold">
            {{ __('classrooms.list') }}
            <span class="font-normal text-ink-subtle tabular-nums">({{ $classrooms->total() }})</span>
        </h2>

        @if ($classrooms->isEmpty())
            <p class="card p-8 text-center text-sm text-ink-muted">{{ __('classrooms.empty') }}</p>
        @else
            <div class="card overflow-x-auto" wire:loading.class="opacity-60">
                <table class="w-full text-left text-sm">
                    <caption class="sr-only">{{ __('classrooms.list') }}</caption>
                    <thead class="border-b border-line text-xs text-ink-subtle">
                        <tr>
                            <th scope="col" class="px-5 py-3 font-medium">{{ __('classrooms.name') }}</th>
                            <th scope="col" class="px-5 py-3 font-medium">{{ __('classrooms.grade') }}</th>
                            <th scope="col" class="px-5 py-3 font-medium">{{ __('classrooms.student_count') }}</th>
                            <th scope="col" class="px-5 py-3 font-medium">{{ __('classrooms.teacher') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @foreach ($classrooms as $classroom)
                            <tr wire:key="classroom-{{ $classroom->id }}" class="transition hover:bg-ground">
                                <td class="px-5 py-3">
                                    <a href="{{ route('classrooms.show', $classroom) }}" class="font-semibold text-brand-700 hover:underline">{{ $classroom->name }}</a>
                                </td>
                                <td class="px-5 py-3 text-ink-muted tabular-nums">{{ $classroom->grade ?? '—' }}</td>
                                <td class="px-5 py-3 text-ink-muted tabular-nums">{{ $classroom->students_count }}</td>
                                <td class="px-5 py-3 text-ink-muted">{{ $classroom->teacher->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $classrooms->links() }}</div>
        @endif
    </section>
</div>
