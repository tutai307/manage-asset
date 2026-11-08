<div class="space-y-10">
    <a href="{{ route('curriculum.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-ink-muted transition hover:text-ink">
        <x-icon name="arrow-left" class="size-4" /> {{ __('curriculum.title') }}
    </a>

    <header class="flex items-start gap-4 border-b border-line pb-6">
        <span class="text-3xl" aria-hidden="true">{{ $unit->emoji }}</span>
        <div class="min-w-0">
            <p class="text-xs font-semibold text-ink-subtle tabular-nums">
                {{ __('curriculum.grade_n', ['grade' => $unit->grade]) }} · {{ $unit->label() }} · {{ __('curriculum.term', ['term' => $unit->term]) }}
            </p>
            <h1 class="mt-1 text-2xl font-bold tracking-tight">{{ $unit->title() }}</h1>
            @if ($unit->title() !== $unit->title_en)
                <p lang="en" class="text-sm text-ink-subtle">{{ $unit->title_en }}</p>
            @endif
            @if ($unit->focus())
                <p class="mt-2 max-w-prose text-sm text-ink-muted">{{ $unit->focus() }}</p>
            @endif
        </div>
    </header>

    @if ($error)
        <p role="alert" class="rounded-lg bg-bad-soft px-4 py-3 text-sm text-bad">{{ $error }}</p>
    @endif

    {{-- What this unit teaches: the teacher's word list and grammar point, from their book --}}
    <section class="card p-5">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div>
                <h2 class="font-semibold">{{ __('curriculum.focus_title') }}</h2>
                <p class="mt-1 max-w-prose text-sm text-ink-muted">{{ __('curriculum.focus_hint') }}</p>
            </div>

            @if ($canManage && ! $editingFocus)
                <div class="flex flex-wrap gap-2">
                    <button type="button" wire:click="suggestFocus" wire:loading.attr="disabled" wire:target="suggestFocus" class="btn-secondary">
                        <span wire:loading.remove wire:target="suggestFocus">{{ __('curriculum.focus_suggest') }}</span>
                        <span wire:loading wire:target="suggestFocus">{{ __('curriculum.generating') }}</span>
                    </button>
                    <button type="button" wire:click="editFocus" class="btn-primary">
                        {{ $unit->vocabulary->isEmpty() ? __('curriculum.focus_add') : __('curriculum.focus_edit') }}
                    </button>
                </div>
            @endif
        </div>

        @if ($canManage && $editingFocus)
            <form wire:submit="saveFocus" class="mt-5 space-y-4">
                <div>
                    <label for="vocabularyText" class="mb-1.5 block text-sm font-medium">{{ __('curriculum.vocabulary') }}</label>
                    <p class="mb-2 text-sm text-ink-subtle">{{ __('curriculum.vocabulary_hint') }}</p>
                    <textarea wire:model="vocabularyText" id="vocabularyText" rows="10" class="form-input font-mono text-sm"
                        placeholder="shop assistant (n) = nhân viên bán hàng&#10;try on (v) = mặc thử&#10;discount (n) = giảm giá"></textarea>
                    @error('vocabularyText') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="grammarEn" class="mb-1.5 block text-sm font-medium">{{ __('curriculum.grammar_en') }}</label>
                        <input wire:model="grammarEn" id="grammarEn" type="text" lang="en" class="form-input" placeholder="Comparative adjectives">
                    </div>
                    <div>
                        <label for="grammarVi" class="mb-1.5 block text-sm font-medium">{{ __('curriculum.grammar_vi') }}</label>
                        <input wire:model="grammarVi" id="grammarVi" type="text" class="form-input" placeholder="So sánh hơn của tính từ">
                    </div>
                </div>

                <div class="flex flex-wrap gap-2">
                    <button type="submit" wire:loading.attr="disabled" wire:target="saveFocus" class="btn-primary">{{ __('curriculum.focus_save') }}</button>
                    <button type="button" wire:click="cancelFocus" class="btn-secondary">{{ __('common.cancel') }}</button>
                </div>
            </form>
        @elseif ($unit->vocabulary->isEmpty())
            <p class="mt-4 rounded-lg bg-warn-soft px-4 py-3 text-sm">{{ $canManage ? __('curriculum.focus_missing_teacher') : __('curriculum.focus_missing_student') }}</p>
        @else
            <div class="mt-5 space-y-4">
                @if ($unit->grammar())
                    <p class="text-sm"><span class="label-eyebrow">{{ __('curriculum.grammar') }}</span><br>{{ $unit->grammar() }}</p>
                @endif

                <div>
                    <p class="label-eyebrow mb-2">{{ __('curriculum.vocabulary') }} ({{ $unit->vocabulary->count() }})</p>
                    <ul class="grid gap-x-6 gap-y-1.5 sm:grid-cols-2">
                        @foreach ($unit->vocabulary as $word)
                            <li wire:key="word-{{ $word->id }}" class="flex items-baseline gap-2 text-sm">
                                <button type="button" x-on:click="speakEnglish(@js($word->word))"
                                    aria-label="{{ __('topics.listen', ['sentence' => $word->word]) }}"
                                    class="text-ink-subtle transition hover:text-brand-600">
                                    <x-icon name="speaker" class="size-4" />
                                </button>
                                <span lang="en" class="font-medium">{{ $word->word }}</span>
                                @if ($word->part_of_speech)
                                    <span class="text-xs text-ink-subtle">({{ $word->part_of_speech }})</span>
                                @endif
                                <span class="text-ink-muted">{{ $word->meaning_vi }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </section>

    @php
        $skillTheme = [
            'speaking' => 'bg-pink-100 text-pink-600',
            'listening' => 'bg-sky-100 text-sky-600',
            'reading' => 'bg-emerald-100 text-emerald-600',
            'writing' => 'bg-amber-100 text-amber-600',
            'language' => 'bg-violet-100 text-violet-600',
        ];
    @endphp

    {{-- Speaking: AI-made situations for this unit, practised by calling a companion --}}
    <section class="card overflow-hidden" aria-labelledby="speaking-title">
        <div class="flex flex-wrap items-center gap-4 bg-gradient-to-r from-pink-50 via-violet-50 to-sky-50 px-5 py-4">
            <span class="grid size-11 place-items-center rounded-xl {{ $skillTheme['speaking'] }}"><x-icon name="microphone" /></span>
            <div class="min-w-0 flex-1">
                <h2 id="speaking-title" class="font-semibold">{{ App\Enums\SkillType::Speaking->label() }}</h2>
                <p class="text-sm text-ink-muted">{{ __('curriculum.speaking_hint') }}</p>
            </div>
            <div class="flex -space-x-3" aria-hidden="true">
                @foreach (App\Enums\Companion::cases() as $companion)
                    <span class="grid size-12 place-items-center rounded-full bg-surface shadow-sm ring-2 ring-surface">
                        <x-companion :companion="$companion" class="size-11" />
                    </span>
                @endforeach
            </div>
        </div>

        @if ($topics->isEmpty())
            <p class="px-5 py-6 text-sm text-ink-muted">{{ $canManage ? __('curriculum.empty_teacher') : __('curriculum.empty_student') }}</p>
        @else
            <ul class="divide-y divide-line">
                @foreach ($topics as $topic)
                    <li wire:key="topic-{{ $topic->id }}" class="px-5 py-4">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-xl" aria-hidden="true">{{ $topic->emoji }}</span>
                            <a href="{{ route('topics.show', $topic) }}" class="font-medium hover:underline">{{ $topic->title() }}</a>
                            <span class="text-sm text-ink-subtle">· {{ trans_choice('topics.pattern_count', $topic->sentence_patterns_count, ['count' => $topic->sentence_patterns_count]) }}</span>
                            @unless ($topic->status->isVisibleToStudents())
                                <span class="rounded-full bg-warn-soft px-2 py-0.5 text-xs font-medium">{{ __('curriculum.not_open') }}</span>
                            @endunless

                            @if ($canManage)
                                <span class="ml-auto flex flex-wrap gap-1">
                                    @if ($topic->status->isVisibleToStudents())
                                        <button type="button" wire:click="unpublish({{ $topic->id }})" class="btn-quiet text-xs">{{ __('curriculum.unpublish') }}</button>
                                    @else
                                        <button type="button" wire:click="publish({{ $topic->id }})" class="btn-secondary px-3 py-1.5 text-xs">{{ __('curriculum.publish') }}</button>
                                    @endif
                                    <button type="button" wire:click="deleteTopic({{ $topic->id }})"
                                        wire:confirm="{{ __('curriculum.delete_topic_confirm', ['title' => $topic->title()]) }}"
                                        class="btn-quiet text-xs text-bad hover:bg-bad-soft">{{ __('skills.delete') }}</button>
                                </span>
                            @endif
                        </div>

                        @if ($topic->roleplayScenarios->isNotEmpty())
                            <ul class="mt-3 grid gap-2 sm:grid-cols-2">
                                @foreach ($topic->roleplayScenarios as $scenario)
                                    <li wire:key="scenario-{{ $scenario->id }}" class="flex items-center gap-3 rounded-xl border border-line bg-ground/60 px-3.5 py-2.5">
                                        <p class="min-w-0 flex-1 text-sm font-medium">{{ $scenario->title() }}</p>
                                        <button type="button" wire:click="startRoleplay({{ $scenario->id }})" wire:loading.attr="disabled" wire:target="startRoleplay({{ $scenario->id }})"
                                            class="inline-flex items-center gap-1.5 rounded-full bg-good px-3.5 py-1.5 text-sm font-semibold text-white transition hover:bg-good/90">
                                            <x-icon name="phone" class="size-4" /> {{ __('curriculum.call') }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif

        @if ($canManage)
            <div class="border-t border-line px-5 py-3">
                <button type="button" wire:click="generate" wire:loading.attr="disabled" wire:target="generate" class="btn-secondary">
                    <x-icon name="sparkles" class="size-4 text-brand-600" />
                    <span wire:loading.remove wire:target="generate">{{ __('curriculum.generate') }}</span>
                    <span wire:loading wire:target="generate">{{ __('curriculum.generating') }}</span>
                </button>
            </div>
        @endif
    </section>

    {{-- The written skills --}}
    <section aria-labelledby="skills-title">
        <h2 id="skills-title" class="mb-3 text-lg font-semibold">{{ __('skills.title') }}</h2>

        <div class="grid gap-4 md:grid-cols-2">
            @foreach ($skills as $skill)
                @continue($skill === App\Enums\SkillType::Speaking)
                @php($list = $exercises[$skill->value] ?? collect())
                <article wire:key="skill-{{ $skill->value }}" class="card flex flex-col">
                    <header class="flex items-center gap-3 px-5 pt-5">
                        <span class="grid size-10 place-items-center rounded-xl {{ $skillTheme[$skill->value] }}"><x-icon :name="$skill->icon()" /></span>
                        <h3 class="font-semibold">{{ $skill->label() }}</h3>
                        <span class="ml-auto rounded-full bg-ground px-2.5 py-0.5 text-xs font-semibold text-ink-muted tabular-nums">{{ $list->count() }}</span>
                    </header>

                    @if ($list->isEmpty())
                        <p class="flex-1 px-5 py-4 text-sm text-ink-muted">{{ $canManage ? __('skills.empty_teacher') : __('skills.empty_student') }}</p>
                    @else
                        <ul class="flex-1 divide-y divide-line px-5 py-2">
                            @foreach ($list as $exercise)
                                <li wire:key="exercise-{{ $exercise->id }}" class="flex flex-wrap items-center gap-x-2 gap-y-1 py-2.5">
                                    <a href="{{ route('exercises.show', $exercise) }}" class="min-w-0 flex-1 text-sm font-medium hover:text-brand-700">
                                        {{ $exercise->title() }}
                                        @if ($exercise->questions_count > 0)
                                            <span class="font-normal text-ink-subtle">· {{ trans_choice('skills.question_count', $exercise->questions_count, ['count' => $exercise->questions_count]) }}</span>
                                        @endif
                                    </a>

                                    @if ($canManage)
                                        @if ($exercise->assignments_count > 0)
                                            <span class="rounded-full bg-good-soft px-2 py-0.5 text-xs font-medium text-good">{{ __('skills.assigned_count', ['count' => $exercise->assignments_count]) }}</span>
                                        @elseif ($exercise->isTeacherOwned() || ! $exercise->status->isVisibleToStudents())
                                            <span class="rounded-full bg-warn-soft px-2 py-0.5 text-xs font-medium">{{ __('skills.not_assigned') }}</span>
                                        @else
                                            <span class="rounded-full bg-ground px-2 py-0.5 text-xs text-ink-muted">{{ __('skills.shipped') }}</span>
                                        @endif

                                        <span class="flex items-center">
                                            @can('update', $exercise)
                                                <a href="{{ route('exercises.edit', $exercise) }}" class="rounded-md p-1.5 text-ink-subtle transition hover:bg-ground hover:text-ink" title="{{ __('skills.edit') }}">
                                                    <x-icon name="pencil" class="size-4" /><span class="sr-only">{{ __('skills.edit') }}</span>
                                                </a>
                                            @endcan
                                            <a href="{{ route('exercises.show', $exercise) }}#assign-title" class="rounded-md p-1.5 text-ink-subtle transition hover:bg-ground hover:text-brand-700" title="{{ __('skills.assign_short') }}">
                                                <x-icon name="send" class="size-4" /><span class="sr-only">{{ __('skills.assign_short') }}</span>
                                            </a>
                                            @can('delete', $exercise)
                                                <button type="button" wire:click="deleteExercise({{ $exercise->id }})"
                                                    wire:confirm="{{ __('skills.delete_confirm', ['title' => $exercise->title()]) }}"
                                                    class="rounded-md p-1.5 text-ink-subtle transition hover:bg-bad-soft hover:text-bad" title="{{ __('skills.delete') }}">
                                                    <x-icon name="trash" class="size-4" /><span class="sr-only">{{ __('skills.delete') }}</span>
                                                </button>
                                            @endcan
                                        </span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    @if ($canManage)
                        <footer class="border-t border-line px-5 py-3">
                            @if ($skill->canBeGenerated())
                                <button type="button" wire:click="generateExercise('{{ $skill->value }}')" wire:loading.attr="disabled" wire:target="generateExercise"
                                    class="btn-secondary">
                                    <x-icon name="sparkles" class="size-4 text-brand-600" />
                                    <span wire:loading.remove wire:target="generateExercise('{{ $skill->value }}')">{{ __('skills.generate') }}</span>
                                    <span wire:loading wire:target="generateExercise('{{ $skill->value }}')">{{ __('curriculum.generating') }}</span>
                                </button>
                            @else
                                <a href="{{ route('exercises.create', ['unit' => $unit->id]) }}" class="btn-secondary">
                                    <x-icon name="plus" class="size-4 text-brand-600" /> {{ __('skills.write_own') }}
                                </a>
                            @endif
                        </footer>
                    @endif
                </article>
            @endforeach
        </div>
    </section>
</div>
