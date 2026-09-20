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

    {{-- Four skills --}}
    <section>
        <h2 class="mb-3 text-lg font-semibold">{{ __('skills.title') }}</h2>

        <div class="grid gap-4 sm:grid-cols-2">
            @foreach ($skills as $skill)
                @php($list = $exercises[$skill->value] ?? collect())
                <article wire:key="skill-{{ $skill->value }}" class="card flex flex-col p-5">
                    <div class="flex items-center gap-2.5">
                        <x-icon :name="$skill->icon()" class="text-brand-600" />
                        <h3 class="font-semibold">{{ $skill->label() }}</h3>
                        <span class="ml-auto text-sm text-ink-subtle tabular-nums">{{ $list->count() }}</span>
                    </div>

                    @if ($skill === App\Enums\SkillType::Speaking)
                        <p class="mt-3 flex-1 text-sm text-ink-muted">{{ __('skills.speaking_is_roleplay') }}</p>
                        @if ($topics->isNotEmpty())
                            <a href="{{ route('topics.show', $topics->first()) }}" class="btn-secondary mt-4 self-start">{{ __('roleplay.start') }}</a>
                        @endif
                    @else
                        @if ($list->isEmpty())
                            <p class="mt-3 flex-1 text-sm text-ink-muted">{{ $canManage ? __('skills.empty_teacher') : __('skills.empty_student') }}</p>
                        @else
                            <ul class="mt-3 flex-1 space-y-2">
                                @foreach ($list as $exercise)
                                    <li wire:key="exercise-{{ $exercise->id }}" class="flex flex-wrap items-center gap-2">
                                        <a href="{{ route('exercises.show', $exercise) }}" class="min-w-0 flex-1 text-sm font-medium hover:underline">
                                            {{ $exercise->title() }}
                                            @if ($exercise->questions_count > 0)
                                                <span class="text-ink-subtle">· {{ trans_choice('skills.question_count', $exercise->questions_count, ['count' => $exercise->questions_count]) }}</span>
                                            @endif
                                        </a>

                                        @unless ($exercise->status->isVisibleToStudents())
                                            <span class="rounded-full border border-warn/50 bg-warn-soft px-2 py-0.5 text-xs">{{ $exercise->status->label() }}</span>
                                        @endunless

                                        @if ($canManage)
                                            <a href="{{ route('exercises.edit', $exercise) }}" class="btn-quiet text-xs">{{ __('curriculum.focus_edit') }}</a>
                                            @if ($exercise->status->isVisibleToStudents())
                                                <button type="button" wire:click="unpublishExercise({{ $exercise->id }})" class="btn-quiet text-xs">{{ __('curriculum.unpublish') }}</button>
                                            @else
                                                <button type="button" wire:click="publishExercise({{ $exercise->id }})" class="btn-quiet text-xs">{{ __('curriculum.publish') }}</button>
                                            @endif
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        @if ($canManage)
                            <button type="button" wire:click="generateExercise('{{ $skill->value }}')" wire:loading.attr="disabled" wire:target="generateExercise"
                                class="btn-secondary mt-4 self-start">
                                <span wire:loading.remove wire:target="generateExercise">{{ __('skills.generate') }}</span>
                                <span wire:loading wire:target="generateExercise">{{ __('curriculum.generating') }}</span>
                            </button>
                        @endif
                    @endif
                </article>
            @endforeach
        </div>
    </section>

    {{-- Conversation packs --}}
    <section>
        <div class="mb-3 flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-lg font-semibold">{{ __('curriculum.lessons') }}</h2>

            @if ($canManage)
                <button type="button" wire:click="generate" wire:loading.attr="disabled" wire:target="generate" class="btn-secondary">
                    <span wire:loading.remove wire:target="generate">{{ __('curriculum.generate') }}</span>
                    <span wire:loading wire:target="generate">{{ __('curriculum.generating') }}</span>
                </button>
            @endif
        </div>

        @if ($topics->isEmpty())
            <p class="card p-8 text-center text-sm text-ink-muted">
                {{ $canManage ? __('curriculum.empty_teacher') : __('curriculum.empty_student') }}
            </p>
        @else
            <ul class="card divide-y divide-line">
                @foreach ($topics as $topic)
                    <li wire:key="topic-{{ $topic->id }}" class="flex flex-wrap items-center gap-4 px-5 py-4">
                        <div class="min-w-0 flex-1">
                            <a href="{{ route('topics.show', $topic) }}" class="font-medium hover:underline">{{ $topic->title() }}</a>
                            <p class="text-sm text-ink-subtle">
                                {{ trans_choice('topics.pattern_count', $topic->sentence_patterns_count, ['count' => $topic->sentence_patterns_count]) }}
                                ·
                                {{ trans_choice('topics.scenario_count', $topic->roleplay_scenarios_count, ['count' => $topic->roleplay_scenarios_count]) }}
                            </p>
                        </div>

                        @unless ($topic->status->isVisibleToStudents())
                            <span class="rounded-full border border-warn/50 bg-warn-soft px-2.5 py-0.5 text-xs font-medium">{{ $topic->status->label() }}</span>
                        @endunless

                        @if ($canManage)
                            @if ($topic->status->isVisibleToStudents())
                                <button type="button" wire:click="unpublish({{ $topic->id }})" class="btn-quiet">{{ __('curriculum.unpublish') }}</button>
                            @else
                                <button type="button" wire:click="publish({{ $topic->id }})" class="btn-secondary">{{ __('curriculum.publish') }}</button>
                            @endif
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
</div>
