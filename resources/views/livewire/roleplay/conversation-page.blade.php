@php
    $finished = $turnsUsed >= $maxTurns;
    $lastLine = $conversation->messages->where('role', App\Enums\MessageRole::Assistant)->last()?->content;
    $initial = mb_strtoupper(mb_substr(Illuminate\Support\Str::afterLast(auth()->user()->name, ' '), 0, 1));
    $stageTheme = [
        'miu' => 'from-orange-100 to-amber-50',
        'robo' => 'from-sky-100 to-slate-100',
        'dino' => 'from-lime-100 to-emerald-50',
        'oli' => 'from-indigo-100 to-violet-50',
    ];
@endphp

<div class="mx-auto max-w-3xl space-y-6" x-data="{ choosing: @js(! $companion) }">
    <a href="{{ route('topics.show', $conversation->scenario->topic) }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-ink-muted transition hover:text-ink">
        <x-icon name="arrow-left" class="size-4" /> {{ $conversation->scenario->topic->title() }}
    </a>

    {{-- AM-024: choose the cartoon companion; remembered for the next role-play --}}
    <section x-show="choosing" x-cloak class="card p-5" aria-labelledby="choose-title">
        <h2 id="choose-title" class="font-semibold">{{ __('companions.choose_title') }}</h2>
        <p class="mt-1 text-sm text-ink-muted">{{ __('companions.choose_hint') }}</p>

        <ul class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
            @foreach ($companions as $option)
                @php($selected = $option === $companion)
                <li wire:key="companion-{{ $option->value }}">
                    <button type="button" wire:click="chooseCompanion('{{ $option->value }}')" x-on:click="choosing = false"
                        aria-pressed="{{ $selected ? 'true' : 'false' }}"
                        @class([
                            'flex h-full w-full flex-col items-center rounded-xl border bg-gradient-to-b p-3 text-center transition hover:-translate-y-0.5 hover:shadow-md focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600',
                            $stageTheme[$option->value],
                            'border-brand-600 ring-2 ring-brand-600' => $selected,
                            'border-line' => ! $selected,
                        ])>
                        <x-companion :companion="$option" class="size-24" />
                        <span class="mt-2 font-semibold">{{ $option->name() }}</span>
                        <span class="text-xs text-ink-muted">{{ $option->tagline() }}</span>
                        @if ($selected)
                            <span class="mt-2 rounded-full bg-brand-600 px-2 py-0.5 text-xs font-semibold text-white">{{ __('companions.chosen') }}</span>
                        @endif
                    </button>
                </li>
            @endforeach
        </ul>
    </section>

    @if ($companion)
        {{-- AM-025: the role-play as a hands-free video call --}}
        <section x-show="! choosing" class="card flex flex-col overflow-hidden" wire:key="call-{{ $companion->value }}"
            x-data="companionCall({
                notAllowed: @js(__('roleplay.mic_not_allowed')),
                noSpeech: @js(__('roleplay.mic_no_speech')),
                failed: @js(__('roleplay.mic_failed')),
                voiceFailed: @js(__('common.speech_failed')),
            })"
            data-voice="{{ json_encode($companion->voice()) }}"
            data-opening="{{ $lastLine }}"
            data-finished="{{ $finished ? '1' : '0' }}"
            x-on:companion-replied.window="onReply($event.detail)"
            x-on:companion-failed.window="onFailed()">

            <header class="flex items-start gap-3 border-b border-line px-5 py-4">
                <span class="text-2xl" aria-hidden="true">{{ $conversation->scenario->topic->emoji }}</span>
                <div class="min-w-0 flex-1">
                    <h1 class="font-semibold">{{ $conversation->scenario->title() }}</h1>
                    <p class="text-sm text-ink-muted">{{ $conversation->scenario->situation() }}</p>
                    {{-- Role names are English prompt text, so they are only shown in the English interface. --}}
                    @if (App\Enums\AppLocale::current() === App\Enums\AppLocale::English)
                        <p class="mt-1 text-xs text-ink-subtle">
                            {{ __('roleplay.roles', ['ai' => $conversation->scenario->ai_role, 'student' => $conversation->scenario->student_role]) }}
                        </p>
                    @endif
                </div>
                <p class="shrink-0 text-right text-xs text-ink-subtle">
                    <span class="block text-base font-semibold text-ink tabular-nums">{{ $turnsUsed }}/{{ $maxTurns }}</span>
                    {{ __('roleplay.turns_label') }}
                </p>
            </header>

            {{-- The stage: the companion, its subtitle, and the student's own tile --}}
            <div x-bind:data-state="state"
                class="relative flex min-h-[23rem] flex-col items-center justify-center bg-gradient-to-b px-4 pt-12 pb-16 {{ $stageTheme[$companion->value] }}">
                <p class="absolute top-3 left-3 flex items-center gap-2 rounded-full bg-surface/85 px-3 py-1 text-xs font-semibold" role="status" aria-live="polite">
                    <span x-show="inCall" class="size-2 rounded-full bg-good"></span>
                    <span x-show="state === 'ready' || state === 'ended'">{{ $companion->name() }}</span>
                    <span x-show="state === 'loading'" x-cloak>{{ __('companions.state_loading', ['name' => $companion->name()]) }}</span>
                    <span x-show="state === 'speaking'" x-cloak>{{ __('companions.state_speaking', ['name' => $companion->name()]) }}</span>
                    <span x-show="state === 'listening'" x-cloak>{{ __('companions.state_listening', ['name' => $companion->name()]) }}</span>
                    <span x-show="state === 'thinking'" x-cloak>{{ __('companions.state_thinking', ['name' => $companion->name()]) }}</span>
                    <span x-show="state === 'paused'" x-cloak>{{ __('companions.state_paused') }}</span>
                </p>

                <div class="relative">
                    <span x-show="state === 'ready'" class="call-ring absolute inset-4 rounded-full bg-surface/70"></span>
                    <x-companion :companion="$companion" class="relative size-56 sm:size-64" />
                    <span x-show="state === 'thinking' || state === 'loading'" x-cloak
                        class="absolute -top-2 right-2 flex gap-1 rounded-full bg-surface px-3 py-2 shadow" aria-hidden="true">
                        <span class="size-2 animate-bounce rounded-full bg-ink-subtle"></span>
                        <span class="size-2 animate-bounce rounded-full bg-ink-subtle [animation-delay:150ms]"></span>
                        <span class="size-2 animate-bounce rounded-full bg-ink-subtle [animation-delay:300ms]"></span>
                    </span>
                </div>

                <p x-show="subtitles && caption && inCall" x-cloak x-text="caption" lang="en"
                    class="mt-4 max-w-md rounded-xl bg-ink/80 px-4 py-2 text-center text-[15px]/6 text-white"></p>

                {{-- The student's own tile. What they say is not shown: the call is face to face,
                     and only the companion has subtitles. A ring runs down before it is sent. --}}
                <div class="absolute right-3 bottom-3 flex items-center gap-2">
                    <span x-show="state === 'listening' && heard" x-cloak class="flex h-5 items-end gap-0.5" aria-hidden="true">
                        <span class="w-1 animate-pulse rounded-full bg-brand-600" style="height: 40%"></span>
                        <span class="w-1 animate-pulse rounded-full bg-brand-600 [animation-delay:150ms]" style="height: 100%"></span>
                        <span class="w-1 animate-pulse rounded-full bg-brand-600 [animation-delay:300ms]" style="height: 65%"></span>
                    </span>
                    <span class="relative grid size-14 shrink-0 place-items-center rounded-full p-1 shadow"
                        x-bind:style="sendCountdown > 0 ? `background: conic-gradient(var(--color-brand-600) ${sendCountdown * 360}deg, transparent 0)` : ''"
                        title="{{ __('roleplay.you') }}">
                        <span x-show="state === 'listening'" x-cloak class="call-ring absolute inset-0 rounded-full bg-brand-400"></span>
                        <span class="relative grid size-full place-items-center rounded-full bg-brand-600 font-semibold text-white ring-2 ring-surface">{{ $initial }}</span>
                    </span>
                </div>
            </div>

            <div class="border-t border-line px-5 py-4">
                @if ($error)
                    <p role="alert" class="mb-3 rounded-lg bg-bad-soft px-3.5 py-2.5 text-sm text-bad">{{ $error }}</p>
                @endif
                <p x-show="error" x-cloak x-text="error" role="alert" class="mb-3 rounded-lg bg-bad-soft px-3.5 py-2.5 text-sm text-bad"></p>

                {{-- Before the call --}}
                <div x-show="state === 'ready'" class="flex flex-col items-center gap-2 text-center">
                    <button type="button" x-on:click="start()" class="btn-primary bg-good px-6 py-3 text-base hover:bg-good/90">
                        <x-icon name="phone" /> {{ __('companions.call_start', ['name' => $companion->name()]) }}
                    </button>
                    <p class="text-sm text-ink-subtle">{{ __('companions.call_start_hint') }}</p>
                    <button type="button" x-on:click="choosing = true" class="btn-quiet">{{ __('companions.change') }}</button>
                </div>

                {{-- While the student is speaking: send now, or start the sentence again --}}
                <div x-show="state === 'listening' && heard" x-cloak class="mb-3 flex flex-wrap items-center justify-center gap-2">
                    <button type="button" x-on:click="sendNow()" class="btn-primary">
                        <x-icon name="send" class="size-4" /> {{ __('companions.done_speaking') }}
                    </button>
                    <button type="button" x-on:click="sayAgain()" class="btn-secondary">
                        <x-icon name="replay" class="size-4" /> {{ __('companions.say_again') }}
                    </button>
                </div>
                <p x-show="state === 'listening' && ! heard && ! typing" x-cloak class="mb-3 text-center text-sm text-ink-muted">
                    {{ __('companions.take_your_time') }}
                </p>

                {{-- During the call --}}
                <div x-show="inCall" x-cloak class="flex flex-wrap items-center justify-center gap-2">
                    <button type="button" x-show="recognition && ! typing" x-on:click="togglePause()" class="btn-secondary"
                        x-bind:aria-pressed="state === 'paused' ? 'true' : 'false'">
                        <span x-show="state !== 'paused'" class="inline-flex items-center gap-2"><x-icon name="pause" class="size-4" /> {{ __('companions.pause') }}</span>
                        <span x-show="state === 'paused'" class="inline-flex items-center gap-2"><x-icon name="microphone" class="size-4" /> {{ __('companions.resume') }}</span>
                    </button>
                    <button type="button" x-on:click="toggleSubtitles()" class="btn-secondary" x-bind:aria-pressed="subtitles ? 'true' : 'false'">
                        <x-icon name="captions" class="size-4" />
                        <span x-text="subtitles ? @js(__('companions.subtitles_off')) : @js(__('companions.subtitles_on'))"></span>
                    </button>
                    <button type="button" x-on:click="repeat()" x-bind:disabled="! caption || state === 'thinking'" class="btn-secondary">
                        <x-icon name="replay" class="size-4" /> {{ __('companions.repeat') }}
                    </button>
                    <button type="button" x-show="recognition" x-on:click="toggleTyping()" class="btn-secondary" x-bind:aria-pressed="typing ? 'true' : 'false'">
                        <x-icon name="pencil" class="size-4" /> {{ __('companions.keyboard') }}
                    </button>
                    <button type="button" wire:click="suggest" wire:loading.attr="disabled" wire:target="suggest" class="btn-secondary">
                        <span wire:loading.remove wire:target="suggest">{{ __('roleplay.hint') }}</span>
                        <span wire:loading wire:target="suggest">{{ __('roleplay.hint_loading') }}</span>
                    </button>
                    <button type="button" x-on:click="end()" class="btn-primary bg-bad hover:bg-bad/90">
                        <x-icon name="phone" class="size-4 rotate-[135deg]" /> {{ __('companions.call_end') }}
                    </button>
                </div>

                @if ($hint)
                    {{-- AM-008 --}}
                    <div x-show="inCall" class="mt-3 rounded-lg border border-line bg-ground px-3.5 py-3">
                        <p class="label-eyebrow">{{ __('companions.say_it') }}</p>
                        <p lang="en" class="mt-1 font-medium">{{ $hint['english'] }}</p>
                        @if ($hint['vietnamese'])
                            <p lang="vi" class="text-sm text-ink-muted">{{ $hint['vietnamese'] }}</p>
                        @endif
                        <div class="mt-2 flex flex-wrap gap-2">
                            <button type="button" wire:click="useHint" x-on:click="typing = true" class="btn-quiet">{{ __('roleplay.hint_use') }}</button>
                            <button type="button" x-on:click="speakEnglish(@js($hint['english']))" class="btn-quiet">
                                <x-icon name="speaker" class="size-4" /> {{ __('roleplay.hint_listen') }}
                            </button>
                        </div>
                    </div>
                @endif

                {{-- Typing: a fallback in the call, and the only way where the browser cannot hear speech --}}
                <div x-show="typing && inCall" x-cloak class="mt-3">
                    <p x-show="! recognition" class="mb-2 text-sm text-ink-muted">{{ __('companions.no_recognition') }}</p>
                    <form x-on:submit.prevent="typed()" class="flex gap-2">
                        <label for="message" class="sr-only">{{ __('roleplay.message') }}</label>
                        <input wire:model="message" id="message" type="text" autocomplete="off" maxlength="300" lang="en"
                            placeholder="{{ __('roleplay.placeholder') }}" class="form-input flex-1">
                        <button type="submit" x-bind:disabled="state === 'thinking'" class="btn-primary">
                            <x-icon name="send" class="size-4" /> {{ __('roleplay.send') }}
                        </button>
                    </form>
                    @error('message') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
                </div>

                {{-- After the call --}}
                <div x-show="state === 'ended'" x-cloak class="flex flex-wrap items-center justify-between gap-3 rounded-lg bg-good-soft px-4 py-3">
                    <p class="text-sm font-medium text-good">{{ $finished ? __('roleplay.finished') : __('companions.call_ended') }}</p>
                    <div class="flex flex-wrap gap-2">
                        @if ($canReview)
                            <button type="button" wire:click="review" wire:loading.attr="disabled" wire:target="review" class="btn-secondary">
                                <span wire:loading.remove wire:target="review">{{ __('review.ask') }}</span>
                                <span wire:loading wire:target="review">{{ __('review.working') }}</span>
                            </button>
                        @endif
                        @unless ($finished)
                            <button type="button" x-on:click="start()" class="btn-secondary">
                                <x-icon name="phone" class="size-4" /> {{ __('companions.call_again') }}
                            </button>
                        @endunless
                        <a href="{{ route('topics.show', $conversation->scenario->topic) }}" class="btn-secondary">{{ __('roleplay.try_another') }}</a>
                    </div>
                </div>
            </div>

            {{-- Everything said so far --}}
            <details class="group border-t border-line">
                <summary class="flex cursor-pointer items-center justify-between px-5 py-3 text-sm font-semibold text-ink-muted hover:text-ink">
                    {{ __('companions.transcript') }}
                    <span class="text-xs font-normal tabular-nums">{{ $conversation->messages->count() }}</span>
                </summary>

                <ol class="space-y-3 px-5 pb-6" aria-live="polite">
                    @foreach ($conversation->messages as $msg)
                        @php($fromStudent = $msg->role === App\Enums\MessageRole::Student)
                        <li wire:key="msg-{{ $msg->id }}" @class(['flex', 'justify-end' => $fromStudent])>
                            <div @class([
                                'max-w-[80%] rounded-2xl px-4 py-2.5 text-sm',
                                'rounded-br-sm bg-brand-600 text-white' => $fromStudent,
                                'rounded-bl-sm border border-line bg-ground' => ! $fromStudent,
                            ])>
                                <span class="sr-only">{{ $fromStudent ? __('roleplay.you') : $companion->name() }}:</span>
                                <span lang="en">{{ $msg->content }}</span>
                                @unless ($fromStudent)
                                    <button type="button" x-on:click="speakEnglish(@js($msg->content))"
                                        aria-label="{{ __('topics.listen', ['sentence' => $msg->content]) }}"
                                        class="ml-1 inline-grid size-6 place-items-center rounded-md align-middle text-ink-subtle transition hover:bg-brand-50 hover:text-brand-600">
                                        <x-icon name="speaker" class="size-4" />
                                    </button>
                                @endunless
                            </div>
                        </li>
                    @endforeach
                </ol>
            </details>
        </section>
    @endif

    {{-- AM-007: the AI's marking of what the student wrote --}}
    @if ($review)
        <section class="card overflow-hidden" id="review">
            <header class="flex flex-wrap items-center justify-between gap-3 border-b border-line px-5 py-4">
                <div>
                    <h2 class="font-semibold">{{ __('review.title') }}</h2>
                    <p class="text-sm text-ink-muted">
                        {{ __('review.scored', ['good' => $review->good_count, 'total' => $review->reviewed_count]) }} ·
                        <time datetime="{{ $review->created_at->toIso8601String() }}">{{ $review->created_at->setTimezone(config('app.display_timezone'))->format('d/m/Y H:i') }}</time>
                    </p>
                </div>
                @if ($review->reviewed_count > 0)
                    <p class="rounded-full bg-ground px-3 py-1 text-sm font-semibold tabular-nums">{{ $review->good_count }}/{{ $review->reviewed_count }}</p>
                @endif
            </header>

            <ol class="divide-y divide-line">
                @foreach ($review->items as $item)
                    <li wire:key="review-item-{{ $item->id }}" class="flex items-start gap-3 px-5 py-4">
                        @if ($item->is_good)
                            <x-icon name="check" class="mt-0.5 size-5 shrink-0 text-good" />
                        @else
                            <x-icon name="pencil" class="mt-0.5 size-5 shrink-0 text-warn" />
                        @endif

                        <div class="min-w-0 flex-1">
                            <p lang="en" @class(['text-sm', 'line-through decoration-line-strong' => ! $item->is_good])>{{ $item->original }}</p>

                            @unless ($item->is_good)
                                @if ($item->better_en)
                                    <p class="mt-1 flex items-start gap-2">
                                        <span lang="en" class="font-medium">{{ $item->better_en }}</span>
                                        <button type="button" x-on:click="speakEnglish(@js($item->better_en))"
                                            aria-label="{{ __('topics.listen', ['sentence' => $item->better_en]) }}"
                                            class="grid size-6 shrink-0 place-items-center rounded-md text-ink-subtle transition hover:bg-brand-50 hover:text-brand-600">
                                            <x-icon name="speaker" class="size-4" />
                                        </button>
                                    </p>
                                @endif
                                @if ($item->note())
                                    <p class="mt-1 text-sm text-ink-muted">{{ $item->note() }}</p>
                                @endif
                            @endunless
                        </div>
                    </li>
                @endforeach
            </ol>

            <p class="border-t border-line bg-ground px-5 py-4 text-sm">{{ $review->summary() }}</p>
        </section>
    @endif
</div>
