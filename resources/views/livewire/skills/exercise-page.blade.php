<div class="mx-auto max-w-3xl space-y-6">
    @if ($exercise->unit)
        <a href="{{ route('curriculum.show', $exercise->unit) }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-ink-muted transition hover:text-ink">
            <x-icon name="arrow-left" class="size-4" /> {{ $exercise->unit->label() }} · {{ $exercise->unit->title() }}
        </a>
    @else
        <a href="{{ route('assignments.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-ink-muted transition hover:text-ink">
            <x-icon name="arrow-left" class="size-4" /> {{ auth()->user()->role->canTeach() ? __('nav.assignments') : __('nav.assigned') }}
        </a>
    @endif

    <header class="border-b border-line pb-5">
        <p class="flex items-center gap-2 text-sm text-ink-muted">
            <x-icon :name="$exercise->skill->icon()" class="size-4 text-brand-600" /> {{ $exercise->skill->label() }}
            @if (auth()->user()->role->canTeach() && ($exercise->isTeacherOwned() || ! $exercise->status->isVisibleToStudents()) && ! $exercise->assignments()->exists())
                <span class="rounded-full bg-warn-soft px-2 py-0.5 text-xs font-medium text-ink">{{ __('skills.not_assigned') }}</span>
            @endif
        </p>
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div>
                <h1 class="mt-1 text-2xl font-bold tracking-tight">{{ $exercise->title() }}</h1>
                <p class="mt-1 text-sm text-ink-muted">{{ $exercise->instructions() }}</p>
            </div>
            @can('update', $exercise)
                <a href="{{ route('exercises.edit', $exercise) }}" class="btn-secondary">
                    <x-icon name="pencil" class="size-4" /> {{ __('skills.edit') }}
                </a>
            @endcan
        </div>
    </header>

    @if (session('status'))
        <p role="status" class="rounded-lg bg-good-soft px-4 py-3 text-sm text-good">{{ session('status') }}</p>
    @endif

    @can('assign', $exercise)
        <livewire:assignments.assign-panel :exercise-id="$exercise->id" :key="'assign-'.$exercise->id" />
    @endcan

    @if ($error)
        <p role="alert" class="rounded-lg bg-bad-soft px-4 py-3 text-sm text-bad">{{ $error }}</p>
    @endif

    {{-- Listening: the text is read aloud and stays hidden until the student has answered --}}
    @if ($exercise->skill === App\Enums\SkillType::Listening)
        <section class="card p-5" x-data="{ revealed: false }">
            <div class="flex flex-wrap items-center gap-3">
                <button type="button" x-on:click="speakEnglish(@js($exercise->passage))" class="btn-primary">
                    <x-icon name="speaker" class="size-4" /> {{ __('skills.play') }}
                </button>
                <button type="button" x-on:click="stopSpeaking()" class="btn-secondary">{{ __('skills.stop') }}</button>
                <p class="text-sm text-ink-subtle">{{ __('skills.play_hint') }}</p>
            </div>

            <div class="mt-4">
                <button type="button" x-on:click="revealed = !revealed" class="btn-quiet">
                    <span x-show="!revealed">{{ __('skills.show_script') }}</span>
                    <span x-show="revealed" x-cloak>{{ __('skills.hide_script') }}</span>
                </button>
                <p lang="en" x-show="revealed" x-cloak class="mt-2 rounded-lg bg-ground p-4 text-sm whitespace-pre-line">{{ $exercise->passage }}</p>
            </div>
        </section>
    @endif

    {{-- Reading: the passage is on the page --}}
    @if ($exercise->skill === App\Enums\SkillType::Reading)
        <section class="card p-5">
            <div class="flex items-start justify-between gap-3">
                <p lang="en" class="max-w-prose text-[15px]/7 whitespace-pre-line">{{ $exercise->passage }}</p>
                <button type="button" x-on:click="speakEnglish(@js($exercise->passage))"
                    aria-label="{{ __('skills.play') }}"
                    class="grid size-9 shrink-0 place-items-center rounded-lg text-ink-subtle transition hover:bg-brand-50 hover:text-brand-600">
                    <x-icon name="speaker" class="size-5" />
                </button>
            </div>
        </section>
    @endif

    {{-- Writing: the task --}}
    @if ($exercise->skill === App\Enums\SkillType::Writing)
        <section class="card p-5">
            <p class="whitespace-pre-line">{{ $exercise->prompt() }}</p>
            @if ($exercise->min_words)
                <p class="mt-3 text-sm text-ink-subtle">{{ __('skills.min_words', ['count' => $exercise->min_words]) }}</p>
            @endif
        </section>
    @endif

    @if ($attempt)
        {{-- Result --}}
        <section class="card overflow-hidden">
            <header class="flex flex-wrap items-center justify-between gap-3 border-b border-line px-5 py-4">
                <h2 class="font-semibold">{{ __('skills.result') }}</h2>
                <p class="flex items-baseline gap-2">
                    <span @class([
                        'text-2xl font-bold tabular-nums',
                        'text-good' => $attempt->percentage() >= 70,
                        'text-warn' => $attempt->percentage() >= 40 && $attempt->percentage() < 70,
                        'text-bad' => $attempt->percentage() < 40,
                    ])>{{ $attempt->score }}/{{ $attempt->max_score }}</span>
                    <span class="text-sm text-ink-subtle tabular-nums">{{ $attempt->percentage() }}%</span>
                </p>
            </header>

            @if ($attempt->feedback())
                <p class="border-b border-line bg-ground px-5 py-4 text-sm whitespace-pre-line">{{ $attempt->feedback() }}</p>
            @endif

            @if ($exercise->questions->isNotEmpty())
                <ol class="divide-y divide-line">
                    @foreach ($exercise->questions as $question)
                        @php($result = $attempt->answers[$question->id] ?? null)
                        <li wire:key="result-{{ $question->id }}" class="flex items-start gap-3 px-5 py-4">
                            <x-icon :name="($result['correct'] ?? false) ? 'check' : 'x'"
                                :class="($result['correct'] ?? false) ? 'mt-0.5 size-5 shrink-0 text-good' : 'mt-0.5 size-5 shrink-0 text-bad'" />
                            <div class="min-w-0 flex-1">
                                <p lang="en" class="text-sm font-medium"><x-marked :text="$question->prompt" :marks="$question->type === App\Enums\QuestionType::Pronunciation" /></p>
                                <p class="mt-1 text-sm">
                                    <span class="text-ink-subtle">{{ __('skills.your_answer') }}:</span>
                                    <x-marked :text="$result['given'] ?? '—'" :marks="$question->type === App\Enums\QuestionType::Pronunciation" lang="en" />
                                </p>
                                @unless ($result['correct'] ?? false)
                                    <p class="text-sm">
                                        <span class="text-ink-subtle">{{ __('skills.correct_answer') }}:</span>
                                        <x-marked :text="$question->answer" :marks="$question->type === App\Enums\QuestionType::Pronunciation" lang="en" class="font-medium text-good" />
                                    </p>
                                    @if ($question->explanation_vi)
                                        <p class="mt-1 text-sm text-ink-muted">{{ $question->explanation_vi }}</p>
                                    @endif
                                @endunless
                            </div>
                        </li>
                    @endforeach
                </ol>
            @endif

            <div class="flex flex-wrap gap-2 border-t border-line px-5 py-4">
                <button type="button" wire:click="tryAgain" class="btn-secondary">{{ __('skills.try_again') }}</button>
                @if ($exercise->unit)
                    <a href="{{ route('curriculum.show', $exercise->unit) }}" class="btn-quiet">{{ __('skills.back_to_unit') }}</a>
                @endif
            </div>
        </section>
    @elseif ($canAttempt)
        {{-- The exercise itself --}}
        <form wire:submit="submit" class="space-y-6">
            @if ($exercise->skill === App\Enums\SkillType::Writing)
                <div class="card p-5">
                    <label for="written" class="mb-2 block text-sm font-medium">{{ __('skills.your_writing') }}</label>
                    <textarea wire:model="written" id="written" rows="10" lang="en" class="form-input" placeholder="{{ __('skills.writing_placeholder') }}"></textarea>
                    @error('written') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
                </div>
            @else
                <ol class="card divide-y divide-line">
                    @foreach ($exercise->questions as $index => $question)
                        <li wire:key="question-{{ $question->id }}" class="px-5 py-4">
                            <p lang="en" class="font-medium">
                                <span class="text-ink-subtle tabular-nums">{{ $index + 1 }}.</span>
                                @if ($question->type === App\Enums\QuestionType::Reorder)
                                    <span lang="vi">{{ __('skills.reorder_tap') }}</span>
                                @else
                                    <x-marked :text="$question->prompt" :marks="$question->type === App\Enums\QuestionType::Pronunciation" />
                                @endif
                            </p>

                            @if ($question->type === App\Enums\QuestionType::Matching)
                                <select wire:model="answers.{{ $question->id }}" lang="en" aria-label="{{ $question->prompt }}" class="form-input mt-3 sm:max-w-sm">
                                    <option value="">{{ __('skills.choose') }}</option>
                                    @foreach ($question->options as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            @elseif ($question->type === App\Enums\QuestionType::Reorder)
                                {{-- Tap the words in order; the sentence built so far is the answer --}}
                                <div x-data="{ words: @js($question->scrambledWords()), picked: [] }"
                                    x-init="$watch('picked', (p) => $wire.set('answers.{{ $question->id }}', p.map((i) => words[i]).join(' '), false))">
                                    <p lang="en" class="mt-3 flex min-h-11 flex-wrap items-center gap-1.5 rounded-lg border border-dashed border-line-strong px-3 py-2">
                                        <template x-for="(i, position) in picked" :key="position">
                                            <button type="button" x-on:click="picked.splice(position, 1)" x-text="words[i]"
                                                class="rounded-md bg-brand-600 px-2.5 py-1 text-sm font-medium text-white"></button>
                                        </template>
                                    </p>
                                    <div class="mt-2 flex flex-wrap items-center gap-1.5" lang="en">
                                        <template x-for="(word, i) in words" :key="i">
                                            <button type="button" x-show="! picked.includes(i)" x-on:click="picked.push(i)" x-text="word"
                                                class="rounded-md border border-line bg-surface px-2.5 py-1 text-sm font-medium transition hover:border-brand-600"></button>
                                        </template>
                                        <button type="button" x-show="picked.length" x-on:click="picked = []" class="btn-quiet text-xs">{{ __('skills.reorder_clear') }}</button>
                                    </div>
                                </div>
                            @elseif ($question->type->hasOptions())
                                <div class="mt-3 grid gap-2" role="group">
                                    @foreach ($question->options as $option)
                                        <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-line px-3.5 py-2.5 text-sm transition hover:bg-ground has-checked:border-brand-600 has-checked:bg-brand-50">
                                            <input type="radio" wire:model="answers.{{ $question->id }}" value="{{ $option }}"
                                                name="question-{{ $question->id }}" class="size-4 text-brand-600 focus:ring-brand-100">
                                            <x-marked :text="$option" :marks="$question->type === App\Enums\QuestionType::Pronunciation" lang="en" />
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <input type="text" wire:model="answers.{{ $question->id }}" lang="en"
                                    aria-label="{{ __('skills.your_answer') }}"
                                    class="form-input mt-3" placeholder="{{ __('skills.type_answer') }}">
                            @endif
                        </li>
                    @endforeach
                </ol>
            @endif

            <button type="submit" wire:loading.attr="disabled" wire:target="submit" class="btn-primary">
                <span wire:loading.remove wire:target="submit">{{ __('skills.submit') }}</span>
                <span wire:loading wire:target="submit">{{ __('skills.marking') }}</span>
            </button>
        </form>
    @else
        <p class="card p-6 text-sm text-ink-muted">{{ __('skills.preview_only') }}</p>
    @endif

    @if ($previousAttempts->isNotEmpty())
        <section>
            <h2 class="label-eyebrow mb-2">{{ __('skills.previous_attempts') }}</h2>
            <ul class="card divide-y divide-line text-sm">
                @foreach ($previousAttempts as $previous)
                    <li wire:key="attempt-{{ $previous->id }}" class="flex items-center justify-between px-5 py-3">
                        <time datetime="{{ $previous->created_at->toIso8601String() }}" class="text-ink-muted">
                            {{ $previous->created_at->setTimezone(config('app.display_timezone'))->format('d/m/Y H:i') }}
                        </time>
                        <span class="font-semibold tabular-nums">{{ $previous->score }}/{{ $previous->max_score }}</span>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif
</div>
