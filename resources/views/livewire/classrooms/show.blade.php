<div class="space-y-8">
    <div>
        <a href="{{ route('classrooms.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-ink-muted transition hover:text-ink">
            <x-icon name="arrow-left" class="size-4" /> {{ __('classrooms.title') }}
        </a>
        <header class="mt-4 border-b border-line pb-6">
            <h1 class="text-2xl font-bold tracking-tight">{{ __('classrooms.class_name', ['name' => $classroom->name]) }}</h1>
            <p class="mt-1 text-sm text-ink-muted">{{ trans_choice('classrooms.student_total', $students->total(), ['count' => $students->total()]) }}</p>
        </header>
    </div>

    @if ($credentials)
        {{-- Shown once, then gone: the only place these passwords are readable. --}}
        <section class="card border-warn/40 bg-warn-soft p-5">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <h2 class="font-semibold">{{ __('classrooms.credentials_title') }}</h2>
                    <p class="mt-1 text-sm text-ink-muted">{{ __('classrooms.credentials_hint') }}</p>
                </div>
                <button type="button" onclick="window.print()" class="btn-secondary">
                    <x-icon name="printer" class="size-4" /> {{ __('classrooms.print') }}
                </button>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <caption class="sr-only">{{ __('classrooms.credentials_title') }}</caption>
                    <thead class="text-xs text-ink-muted">
                        <tr>
                            <th scope="col" class="py-2 pr-4 font-medium">{{ __('classrooms.student_name') }}</th>
                            <th scope="col" class="py-2 pr-4 font-medium">{{ __('auth.username') }}</th>
                            <th scope="col" class="py-2 font-medium">{{ __('auth.password_label') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-warn/20">
                        @foreach ($credentials as $i => $row)
                            <tr wire:key="credential-{{ $i }}">
                                <td class="py-2 pr-4">{{ $row['name'] }}</td>
                                <td class="py-2 pr-4 font-mono">{{ $row['username'] }}</td>
                                <td class="py-2 font-mono font-semibold">{{ $row['password'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    @endif

    <section class="card p-5">
        <h2 class="font-semibold">{{ __('classrooms.add_students') }}</h2>

        <form wire:submit="addStudents" class="mt-4 space-y-3">
            <label for="studentNames" class="block text-sm text-ink-muted">{{ __('classrooms.student_names_hint') }}</label>
            <textarea wire:model="studentNames" id="studentNames" rows="5" placeholder="Nguyễn Văn An&#10;Lê Thị Bình" class="form-input"></textarea>
            @error('studentNames') <p class="text-sm text-bad">{{ $message }}</p> @enderror

            <button type="submit" wire:loading.attr="disabled" wire:target="addStudents" class="btn-primary">
                {{ __('classrooms.add_students_button') }}
            </button>
        </form>
    </section>

    <section>
        <h2 class="mb-3 text-lg font-semibold">
            {{ __('classrooms.students') }}
            <span class="font-normal text-ink-subtle tabular-nums">({{ $students->total() }})</span>
        </h2>

        @if ($students->isEmpty())
            <p class="card p-8 text-center text-sm text-ink-muted">{{ __('classrooms.no_students') }}</p>
        @else
            <div class="card overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <caption class="sr-only">{{ __('classrooms.students') }}</caption>
                    <thead class="border-b border-line text-xs text-ink-subtle">
                        <tr>
                            <th scope="col" class="px-5 py-3 font-medium">{{ __('classrooms.student_name') }}</th>
                            <th scope="col" class="px-5 py-3 font-medium">{{ __('auth.username') }}</th>
                            <th scope="col" class="px-5 py-3"><span class="sr-only">{{ __('common.actions') }}</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @foreach ($students as $student)
                            <tr wire:key="student-{{ $student->id }}">
                                <td class="px-5 py-3 font-medium">{{ $student->name }}</td>
                                <td class="px-5 py-3 font-mono text-ink-muted">{{ $student->username }}</td>
                                <td class="px-5 py-3 text-right">
                                    <button type="button"
                                        wire:click="resetPassword({{ $student->id }})"
                                        wire:confirm="{{ __('classrooms.reset_password_confirm', ['name' => $student->name]) }}"
                                        class="btn-quiet">
                                        <x-icon name="key" class="size-4" /> {{ __('classrooms.reset_password') }}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $students->links() }}</div>
        @endif
    </section>
</div>
