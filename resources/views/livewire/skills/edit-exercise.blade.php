@php
    $source = $exercise->source_files ?? [];
    $files = $source['files'] ?? [];
@endphp

<div @class(['mx-auto space-y-6', 'max-w-6xl' => $files, 'max-w-3xl' => ! $files])>
    <a href="{{ route('exercises.show', $exercise) }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-ink-muted transition hover:text-ink">
        <x-icon name="arrow-left" class="size-4" /> {{ $exercise->title() }}
    </a>

    <header class="border-b border-line pb-5">
        <p class="flex flex-wrap items-center gap-2 text-sm text-ink-muted">
            <x-icon :name="$exercise->skill->icon()" class="size-4 text-brand-600" />
            {{ $exercise->skill->label() }} ·
            @if ($exercise->unit)
                {{ $exercise->unit->label() }} {{ $exercise->unit->title() }}
            @else
                {{ __('skills.no_unit_label') }}@if ($exercise->grade) · {{ __('curriculum.grade_n', ['grade' => $exercise->grade]) }}@endif
            @endif
            <span class="rounded-full bg-ground px-2 py-0.5 text-xs">{{ $exercise->source->label() }}</span>
        </p>
        <h1 class="mt-1 text-2xl font-bold tracking-tight">{{ __('skills.edit') }}</h1>
        <p class="mt-1 text-sm text-ink-muted">{{ __('skills.edit_hint') }}</p>
    </header>

    @if (session('status'))
        <p role="status" class="rounded-lg bg-good-soft px-4 py-3 text-sm text-good">{{ session('status') }}</p>
    @endif

    @if ($source['looks_like_textbook'] ?? false)
        <p role="alert" class="rounded-lg bg-warn-soft px-4 py-3 text-sm">{{ __('skills.looks_like_textbook') }}</p>
    @endif

    <div @class(['grid items-start gap-6', 'lg:grid-cols-[minmax(0,5fr)_minmax(0,6fr)]' => $files])>
        @if ($files)
            {{-- AM-029: the uploaded test, beside the editor, for a question-by-question check --}}
            <aside class="card overflow-hidden lg:sticky lg:top-6" aria-label="{{ __('skills.original') }}">
                <h2 class="border-b border-line px-4 py-3 text-sm font-semibold">{{ __('skills.original') }}</h2>
                <div class="max-h-[75vh] space-y-3 overflow-y-auto bg-ground p-3">
                    @foreach ($files as $index => $file)
                        @if ($originalsExist[$index] ?? false)
                            @if (str_ends_with($file, '.pdf'))
                                <iframe src="{{ route('exercises.source', [$exercise, $index]) }}" title="{{ __('skills.original') }}" class="h-[70vh] w-full rounded-md bg-surface"></iframe>
                            @else
                                <a href="{{ route('exercises.source', [$exercise, $index]) }}" target="_blank" rel="noopener">
                                    <img src="{{ route('exercises.source', [$exercise, $index]) }}" alt="{{ __('skills.original') }} {{ $index + 1 }}" class="w-full rounded-md bg-surface">
                                </a>
                            @endif
                        @else
                            <p class="rounded-md bg-surface px-3 py-2 text-sm text-ink-muted">{{ __('skills.original_missing') }}</p>
                        @endif
                    @endforeach
                </div>
            </aside>
        @endif

        <form wire:submit="save" class="min-w-0 space-y-6">
            <section class="card space-y-4 p-5">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="titleVi" class="mb-1.5 block text-sm font-medium">{{ __('skills.title_vi') }}</label>
                        <input wire:model="titleVi" id="titleVi" type="text" class="form-input">
                        @error('titleVi') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="titleEn" class="mb-1.5 block text-sm font-medium">{{ __('skills.title_en') }}</label>
                        <input wire:model="titleEn" id="titleEn" type="text" lang="en" class="form-input">
                        @error('titleEn') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="instructionsVi" class="mb-1.5 block text-sm font-medium">{{ __('skills.instructions') }} (VI)</label>
                        <input wire:model="instructionsVi" id="instructionsVi" type="text" class="form-input">
                        @error('instructionsVi') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="instructionsEn" class="mb-1.5 block text-sm font-medium">{{ __('skills.instructions') }} (EN)</label>
                        <input wire:model="instructionsEn" id="instructionsEn" type="text" lang="en" class="form-input">
                        @error('instructionsEn') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
                    </div>
                </div>

                @if ($exercise->skill->usesPassage() || $exercise->skill === App\Enums\SkillType::Language)
                    <div>
                        <label for="passage" class="mb-1.5 block text-sm font-medium">
                            {{ $exercise->skill === App\Enums\SkillType::Listening ? __('skills.script') : __('skills.passage') }}
                        </label>
                        <textarea wire:model="passage" id="passage" rows="{{ $exercise->skill->usesPassage() ? 10 : 4 }}" lang="en" class="form-input"></textarea>
                        @error('passage') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
                    </div>
                @endif

                @if ($exercise->skill === App\Enums\SkillType::Writing)
                    <div class="grid gap-4">
                        <div>
                            <label for="promptVi" class="mb-1.5 block text-sm font-medium">{{ __('skills.task') }} (VI)</label>
                            <textarea wire:model="promptVi" id="promptVi" rows="5" class="form-input"></textarea>
                            @error('promptVi') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="promptEn" class="mb-1.5 block text-sm font-medium">{{ __('skills.task') }} (EN)</label>
                            <textarea wire:model="promptEn" id="promptEn" rows="5" lang="en" class="form-input"></textarea>
                            @error('promptEn') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
                        </div>
                        <div class="w-40">
                            <label for="minWords" class="mb-1.5 block text-sm font-medium">{{ __('skills.min_word_count') }}</label>
                            <input wire:model="minWords" id="minWords" type="number" min="20" max="300" class="form-input">
                            @error('minWords') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
                        </div>
                    </div>
                @endif
            </section>

            @if ($source['skipped'] ?? [])
                <section class="card border-warn/50 p-5">
                    <h2 class="font-semibold">{{ __('skills.skipped') }}</h2>
                    <p class="mt-1 text-sm text-ink-muted">{{ __('skills.skipped_hint') }}</p>
                    <ul class="mt-3 list-disc space-y-1 pl-5 text-sm" lang="en">
                        @foreach ($source['skipped'] as $part)
                            <li>{{ $part }}</li>
                        @endforeach
                    </ul>
                </section>
            @endif

            @unless ($exercise->skill === App\Enums\SkillType::Writing)
                <section class="space-y-3">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <h2 class="text-lg font-semibold">{{ __('skills.questions') }}</h2>
                        <button type="button" wire:click="addQuestion" class="btn-secondary">
                            <x-icon name="plus" class="size-4" /> {{ __('skills.add_question') }}
                        </button>
                    </div>

                    @error('questions') <p class="text-sm text-bad">{{ $message }}</p> @enderror

                    @foreach ($questions as $index => $question)
                        @php($type = App\Enums\QuestionType::from($question['type']))
                        <article wire:key="question-row-{{ $index }}-{{ $question['id'] ?? 'new' }}"
                            @class(['card space-y-3 p-5', 'border-warn ring-1 ring-warn/40' => $question['needs_check'] ?? false])>
                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <p class="flex items-center gap-2 text-sm font-semibold text-ink-subtle tabular-nums">
                                    {{ __('skills.question_n', ['number' => $index + 1]) }}
                                    @if ($question['needs_check'] ?? false)
                                        <span class="rounded-full bg-warn-soft px-2 py-0.5 text-xs font-medium text-ink" title="{{ __('skills.needs_check_hint') }}">{{ __('skills.needs_check') }}</span>
                                    @endif
                                </p>
                                <button type="button" wire:click="removeQuestion({{ $index }})"
                                    wire:confirm="{{ __('skills.remove_question_confirm') }}"
                                    class="btn-quiet text-bad hover:bg-bad-soft">{{ __('skills.remove_question') }}</button>
                            </div>

                            <div class="grid gap-3 sm:grid-cols-[200px_1fr]">
                                <div>
                                    <label for="type-{{ $index }}" class="mb-1.5 block text-sm font-medium">{{ __('skills.question_type') }}</label>
                                    <select wire:model.live="questions.{{ $index }}.type" id="type-{{ $index }}" class="form-input">
                                        @foreach ($questionTypes as $option)
                                            <option value="{{ $option->value }}">{{ $option->label() }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="prompt-{{ $index }}" class="mb-1.5 block text-sm font-medium">{{ __('skills.question_prompt') }}</label>
                                    <input wire:model="questions.{{ $index }}.prompt" id="prompt-{{ $index }}" type="text" lang="en" class="form-input">
                                    @error("questions.{$index}.prompt") <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            @if (Lang::has("skills.type_hint.{$type->value}"))
                                <p class="text-xs text-ink-subtle">{{ __("skills.type_hint.{$type->value}") }}</p>
                            @endif

                            @if ($type->hasOptions())
                                <div>
                                    <label for="options-{{ $index }}" class="mb-1.5 block text-sm font-medium">{{ __('skills.options') }}</label>
                                    <textarea wire:model="questions.{{ $index }}.options" id="options-{{ $index }}" rows="4" lang="en"
                                        class="form-input" placeholder="{{ __('skills.options_hint') }}"></textarea>
                                    @error("questions.{$index}.options") <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
                                </div>
                            @endif

                            <div class="grid gap-3 sm:grid-cols-2">
                                <div>
                                    <label for="answer-{{ $index }}" class="mb-1.5 block text-sm font-medium">{{ __('skills.answer') }}</label>
                                    <input wire:model="questions.{{ $index }}.answer" id="answer-{{ $index }}" type="text" lang="en" class="form-input">
                                    @error("questions.{$index}.answer") <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="explanation-{{ $index }}" class="mb-1.5 block text-sm font-medium">{{ __('skills.explanation') }}</label>
                                    <input wire:model="questions.{{ $index }}.explanation_vi" id="explanation-{{ $index }}" type="text" class="form-input">
                                    @error("questions.{$index}.explanation_vi") <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            @if ($type->acceptsAlternatives())
                                <div>
                                    <label for="accepted-{{ $index }}" class="mb-1.5 block text-sm font-medium">{{ __('skills.accepted_answers') }}</label>
                                    <textarea wire:model="questions.{{ $index }}.accepted_answers" id="accepted-{{ $index }}" rows="2" lang="en"
                                        class="form-input" placeholder="{{ __('skills.accepted_answers_hint') }}"></textarea>
                                    @error("questions.{$index}.accepted_answers") <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
                                </div>
                            @endif
                        </article>
                    @endforeach

                    @if ($questions)
                        <button type="button" wire:click="addQuestion" class="btn-secondary">
                            <x-icon name="plus" class="size-4" /> {{ __('skills.add_question') }}
                        </button>
                    @endif
                </section>
            @endunless

            <div class="flex flex-wrap gap-2">
                <button type="submit" wire:loading.attr="disabled" wire:target="save" class="btn-primary">{{ __('skills.save') }}</button>
                <a href="{{ route('exercises.show', $exercise) }}" class="btn-secondary">{{ __('common.cancel') }}</a>
            </div>
        </form>
    </div>
</div>
