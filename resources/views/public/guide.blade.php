@php
    $parts = __('guide.parts');
    // The text comes from this project's own language files; **bold** marks the name of a button.
    $inline = fn (string $text) => Illuminate\Support\Str::inlineMarkdown($text, ['html_input' => 'escape', 'allow_unsafe_links' => false]);
@endphp

<x-public-layout :title="__('guide.title')" :description="__('guide.meta_description')">
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-8 lg:py-14">
        <header class="max-w-3xl border-b border-line pb-8">
            <h1 class="text-4xl font-bold tracking-tight">{{ __('guide.title') }}</h1>
            <p class="mt-3 text-lg/8 text-ink-muted">{{ __('guide.intro') }}</p>

            <nav class="mt-6 flex flex-wrap gap-2 lg:hidden" aria-label="{{ __('guide.contents') }}">
                @foreach ($parts as $part)
                    <a href="#{{ $part['id'] }}" class="btn-secondary px-3 py-1.5">{{ $part['title'] }}</a>
                @endforeach
            </nav>
        </header>

        <div class="mt-10 grid gap-12 lg:grid-cols-[15rem_minmax(0,1fr)]">
            <aside class="hidden lg:block">
                <nav class="sticky top-24 max-h-[calc(100vh-7rem)] overflow-y-auto pr-2" aria-label="{{ __('guide.contents') }}">
                    <p class="label-eyebrow">{{ __('guide.contents') }}</p>
                    <ul class="mt-3 space-y-5">
                        @foreach ($parts as $part)
                            <li>
                                <a href="#{{ $part['id'] }}" class="text-sm font-semibold hover:text-brand-700">{{ $part['title'] }}</a>
                                <ul class="mt-1.5 space-y-1 border-l border-line">
                                    @foreach ($part['topics'] as $topic)
                                        <li>
                                            <a href="#{{ $topic['id'] }}" class="block py-0.5 pl-3 text-sm text-ink-muted hover:text-brand-700">{{ $topic['title'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </aside>

            <main class="max-w-3xl space-y-16 [&_strong]:font-semibold [&_strong]:text-ink [&_code]:rounded [&_code]:bg-brand-50 [&_code]:px-1.5 [&_code]:py-0.5 [&_code]:text-sm">
                @foreach ($parts as $part)
                    <section aria-labelledby="{{ $part['id'] }}">
                        <h2 id="{{ $part['id'] }}" class="scroll-mt-24 text-2xl font-bold tracking-tight">{{ $part['title'] }}</h2>
                        <p class="mt-2 text-ink-muted">{{ $part['intro'] }}</p>

                        <div class="mt-8 space-y-10">
                            @foreach ($part['topics'] as $topic)
                                <article>
                                    <h3 id="{{ $topic['id'] }}" class="scroll-mt-24 text-lg font-semibold">{{ $topic['title'] }}</h3>

                                    @isset($topic['body'])
                                        <p class="mt-2 leading-7 text-ink-muted">{!! $inline($topic['body']) !!}</p>
                                    @endisset

                                    @isset($topic['steps'])
                                        <ol class="mt-3 list-decimal space-y-2 pl-6 leading-7 text-ink-muted marker:font-semibold marker:text-brand-700">
                                            @foreach ($topic['steps'] as $step)
                                                <li class="pl-1">{!! $inline($step) !!}</li>
                                            @endforeach
                                        </ol>
                                    @endisset

                                    @isset($topic['tips'])
                                        <div class="mt-4 rounded-lg border border-line bg-brand-50 px-4 py-3">
                                            <p class="text-sm font-semibold text-brand-700">{{ __('guide.tips') }}</p>
                                            <ul class="mt-1.5 list-disc space-y-1 pl-5 text-sm/6">
                                                @foreach ($topic['tips'] as $tip)
                                                    <li>{!! $inline($tip) !!}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endisset
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endforeach
            </main>
        </div>
    </div>
</x-public-layout>
