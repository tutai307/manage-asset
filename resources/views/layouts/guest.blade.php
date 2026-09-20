<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }} · {{ __('common.app_name') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body class="min-h-screen bg-ground font-sans text-ink antialiased">
        <div class="grid min-h-screen lg:grid-cols-[1fr_1.1fr]">
            {{-- Left: what the product does, shown with one real exchange from the Shopping topic. --}}
            <section class="hidden flex-col justify-between border-r border-line bg-surface p-12 lg:flex">
                <div class="flex items-center gap-2.5">
                    <span class="grid size-9 place-items-center rounded-lg bg-brand-600 text-sm font-bold text-white">EB</span>
                    <span class="text-base font-bold">{{ __('common.app_name') }}</span>
                </div>

                <div class="max-w-sm">
                    <h2 class="text-3xl leading-snug font-bold text-balance">{{ __('auth.hero_title') }}</h2>

                    <dl class="mt-8 space-y-5">
                        @foreach (['book', 'chat', 'speaker'] as $i => $icon)
                            <div class="flex gap-3">
                                <x-icon :name="$icon" class="mt-0.5 text-brand-600" />
                                <dd class="text-sm text-ink-muted">{{ __("auth.hero_points.{$i}") }}</dd>
                            </div>
                        @endforeach
                    </dl>

                    <div class="mt-10 space-y-2 border-t border-line pt-6" aria-hidden="true">
                        <p class="label-eyebrow">{{ __('auth.sample_label') }}</p>
                        <p lang="en" class="w-fit rounded-lg rounded-bl-sm border border-line px-3.5 py-2 text-sm">Hello! Can I help you?</p>
                        <p lang="en" class="ml-auto w-fit rounded-lg rounded-br-sm bg-brand-600 px-3.5 py-2 text-sm text-white">How much is this T-shirt?</p>
                    </div>
                </div>

                <p class="text-xs text-ink-subtle">{{ __('auth.school_line') }}</p>
            </section>

            {{-- Right: the form --}}
            <main class="relative flex items-center justify-center px-4 py-12">
                <x-locale-switcher class="absolute top-4 right-4" />
                <div class="w-full max-w-sm">
                    {{ $slot }}
                </div>
            </main>
        </div>

        @livewireScripts
    </body>
</html>
