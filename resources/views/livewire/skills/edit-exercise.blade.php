<div class="mx-auto max-w-3xl space-y-6">
    <a href="{{ route('exercises.show', $exercise) }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-ink-muted transition hover:text-ink">
        <x-icon name="arrow-left" class="size-4" /> {{ $exercise->title() }}
    </a>

    <header class="border-b border-line pb-5">
        <p class="flex items-center gap-2 text-sm text-ink-muted">
            <x-icon :name="$exercise->skill->icon()" class="size-4 text-brand-600" />
            {{ $exercise->skill->label() }} · {{ $exercise->unit->label() }} {{ $exercise->unit->title() }}
        </p>
        <h1 class="mt-1 text-2xl font-bold tracking-tight">{{ __('skills.edit') }}</h1>
        <p class="mt-1 text-sm text-ink-muted">{{ __('skills.edit_hint') }}</p>
    </header>

    <form wire:submit="save" class="space-y-6">
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

            @if ($exercise->skill->usesPassage())
                <div>
                    <label for="passage" class="mb-1.5 block text-sm font-medium">
                        {{ $exercise->skill === App\Enums\SkillType::Listening ? __('skills.script') : __('skills.passage') }}
                    </label>
                    <textarea wire:model="passage" id="passage" rows="10" lang="en" class="form-input"></textarea>
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
                    <article wire:key="question-row-{{ $index }}-{{ $question['id'] ?? 'new' }}" class="card space-y-3 p-5">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <p class="text-sm font-semibold text-ink-subtle tabular-nums">{{ __('skills.question_n', ['number' => $index + 1]) }}</p>
                            <button type="button" wire:click="removeQuestion({{ $index }})"
                                wire:confirm="{{ __('skills.remove_question_confirm') }}"
                                class="btn-quiet text-bad hover:bg-bad-soft">{{ __('skills.remove_question') }}</button>
                        </div>

                        <div class="grid gap-3 sm:grid-cols-[180px_1fr]">
                            <div>
                                <label for="type-{{ $index }}" class="mb-1.5 block text-sm font-medium">{{ __('skills.question_type') }}</label>
                                <select wire:model.live="questions.{{ $index }}.type" id="type-{{ $index }}" class="form-input">
                                    @foreach ($questionTypes as $type)
                                        <option value="{{ $type->value }}">{{ $type->label() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="prompt-{{ $index }}" class="mb-1.5 block text-sm font-medium">{{ __('skills.question_prompt') }}</label>
                                <input wire:model="questions.{{ $index }}.prompt" id="prompt-{{ $index }}" type="text" lang="en" class="form-input">
                                @error("questions.{$index}.prompt") <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        @if (App\Enums\QuestionType::from($question['type'])->hasOptions())
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
                    </article>
                @endforeach
            </section>
        @endunless

        <div class="flex flex-wrap gap-2">
            <button type="submit" wire:loading.attr="disabled" wire:target="save" class="btn-primary">{{ __('skills.save') }}</button>
            <a href="{{ route('exercises.show', $exercise) }}" class="btn-secondary">{{ __('common.cancel') }}</a>
        </div>
    </form>
</div>
