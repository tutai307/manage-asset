<div class="mx-auto max-w-3xl space-y-6">
    <a href="{{ route('topics.show', $conversation->scenario->topic) }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-ink-muted transition hover:text-ink">
        <x-icon name="arrow-left" class="size-4" /> {{ $conversation->scenario->topic->title() }}
    </a>

    <section class="card flex flex-col overflow-hidden">
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

        <ol class="space-y-3 px-5 py-6" aria-live="polite">
            @foreach ($conversation->messages as $msg)
                @php($fromStudent = $msg->role === App\Enums\MessageRole::Student)
                <li wire:key="msg-{{ $msg->id }}" @class(['flex', 'justify-end' => $fromStudent])>
                    <div @class([
                        'max-w-[80%] rounded-2xl px-4 py-2.5 text-sm',
                        'rounded-br-sm bg-brand-600 text-white' => $fromStudent,
                        'rounded-bl-sm border border-line bg-ground' => ! $fromStudent,
                    ])>
                        <span class="sr-only">{{ $fromStudent ? __('roleplay.you') : __('roleplay.partner') }}:</span>
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

            <li wire:loading.flex wire:target="send">
                <p class="rounded-2xl rounded-bl-sm border border-line bg-ground px-4 py-2.5 text-sm text-ink-subtle">{{ __('roleplay.thinking') }}</p>
            </li>
        </ol>

        <div class="border-t border-line px-5 py-4">
            @if ($error)
                <p role="alert" class="mb-3 rounded-lg bg-bad-soft px-3.5 py-2.5 text-sm text-bad">{{ $error }}</p>
            @endif

            @if ($hint)
                {{-- AM-008 --}}
                <div class="mb-3 rounded-lg border border-line bg-ground px-3.5 py-3">
                    <p class="label-eyebrow">{{ __('roleplay.hint_label') }}</p>
                    <p lang="en" class="mt-1 font-medium">{{ $hint['english'] }}</p>
                    @if ($hint['vietnamese'])
                        <p lang="vi" class="text-sm text-ink-muted">{{ $hint['vietnamese'] }}</p>
                    @endif
                    <div class="mt-2 flex flex-wrap gap-2">
                        <button type="button" wire:click="useHint" class="btn-quiet">{{ __('roleplay.hint_use') }}</button>
                        <button type="button" x-on:click="speakEnglish(@js($hint['english']))" class="btn-quiet">
                            <x-icon name="speaker" class="size-4" /> {{ __('roleplay.hint_listen') }}
                        </button>
                    </div>
                </div>
            @endif

            @if ($turnsUsed < $maxTurns)
                <div x-data="speechInput({
                        notAllowed: @js(__('roleplay.mic_not_allowed')),
                        noSpeech: @js(__('roleplay.mic_no_speech')),
                        failed: @js(__('roleplay.mic_failed')),
                     })">
                    <form wire:submit="send" class="flex gap-2">
                        <label for="message" class="sr-only">{{ __('roleplay.message') }}</label>
                        <input wire:model="message" id="message" type="text" autocomplete="off" maxlength="300" lang="en"
                            placeholder="{{ __('roleplay.placeholder') }}" class="form-input flex-1">

                        {{-- AM-006: hidden where the browser has no speech recognition. --}}
                        <template x-if="supported">
                            <button type="button" x-on:click="toggle()"
                                x-bind:aria-pressed="listening ? 'true' : 'false'"
                                x-bind:aria-label="listening ? @js(__('roleplay.mic_stop')) : @js(__('roleplay.mic_start'))"
                                x-bind:class="listening ? 'border-bad bg-bad-soft text-bad' : 'border-line text-ink-muted hover:bg-ground'"
                                class="grid size-11 shrink-0 place-items-center rounded-lg border transition">
                                <x-icon name="microphone" class="size-5" />
                                <span class="sr-only" x-text="listening ? @js(__('roleplay.mic_stop')) : @js(__('roleplay.mic_start'))"></span>
                            </button>
                        </template>

                        <button type="submit" wire:loading.attr="disabled" wire:target="send" class="btn-primary">
                            {{ __('roleplay.send') }}
                        </button>
                    </form>

                    <p x-show="listening" x-cloak class="mt-2 flex items-center gap-2 text-sm text-bad" role="status">
                        <span class="size-2 animate-pulse rounded-full bg-bad"></span> {{ __('roleplay.mic_listening') }}
                    </p>
                    <p x-show="error" x-cloak x-text="error" role="alert" class="mt-2 text-sm text-bad"></p>
                </div>

                @error('message') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror

                <div class="mt-3 flex flex-wrap gap-2">
                    <button type="button" wire:click="suggest" wire:loading.attr="disabled" wire:target="suggest" class="btn-secondary">
                        <span wire:loading.remove wire:target="suggest">{{ __('roleplay.hint') }}</span>
                        <span wire:loading wire:target="suggest">{{ __('roleplay.hint_loading') }}</span>
                    </button>

                    @if ($canReview)
                        <button type="button" wire:click="review" wire:loading.attr="disabled" wire:target="review" class="btn-secondary">
                            <span wire:loading.remove wire:target="review">{{ __('review.ask') }}</span>
                            <span wire:loading wire:target="review">{{ __('review.working') }}</span>
                        </button>
                    @endif
                </div>
            @else
                <div class="flex flex-wrap items-center justify-between gap-3 rounded-lg bg-good-soft px-4 py-3">
                    <p class="text-sm font-medium text-good">{{ __('roleplay.finished') }}</p>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" wire:click="review" wire:loading.attr="disabled" wire:target="review" class="btn-secondary">
                            <span wire:loading.remove wire:target="review">{{ __('review.ask') }}</span>
                            <span wire:loading wire:target="review">{{ __('review.working') }}</span>
                        </button>
                        <a href="{{ route('topics.show', $conversation->scenario->topic) }}" class="btn-secondary">{{ __('roleplay.try_another') }}</a>
                    </div>
                </div>
            @endif
        </div>
    </section>

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
