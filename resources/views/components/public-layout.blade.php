@props(['title', 'description'])

{{-- The shell of the pages anyone can open without an account. No Livewire, no scripts. --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth motion-reduce:scroll-auto">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title }} · {{ __('common.app_name') }}</title>
        <meta name="description" content="{{ $description }}">
        <meta property="og:type" content="website">
        <meta property="og:title" content="{{ $title }} · {{ __('common.app_name') }}">
        <meta property="og:description" content="{{ $description }}">
        <meta property="og:url" content="{{ url()->current() }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">

        @vite('resources/css/app.css')
    </head>
    <body class="flex min-h-screen flex-col bg-ground font-sans text-ink antialiased">
        <header class="sticky top-0 z-30 border-b border-line bg-surface">
            <div class="mx-auto flex max-w-6xl items-center gap-2 px-4 py-3 sm:gap-4 sm:px-8">
                <a href="{{ route('landing') }}" class="flex items-center gap-2.5 rounded-lg focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600">
                    <span class="grid size-9 place-items-center rounded-lg bg-brand-600 text-sm font-bold text-white">EB</span>
                    <span class="hidden text-base font-bold sm:inline">{{ __('common.app_name') }}</span>
                </a>

                <nav class="ml-auto flex items-center gap-1 sm:gap-2" aria-label="{{ __('common.main_nav') }}">
                    {{-- On a phone there is no room here; the hero and the footer carry this link. --}}
                    <a href="{{ route('guide') }}" @if (request()->routeIs('guide')) aria-current="page" @endif class="btn-quiet hidden sm:inline-flex">{{ __('nav.guide') }}</a>
                </nav>

                <x-locale-switcher />

                @auth
                    <a href="{{ route('home') }}" class="btn-primary">{{ __('nav.go_to_app') }}</a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary">{{ __('auth.sign_in') }}</a>
                @endauth
            </div>
        </header>

        <div class="flex-1">
            {{ $slot }}
        </div>

        <footer class="border-t border-line bg-surface">
            <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-x-8 gap-y-3 px-4 py-6 text-sm text-ink-muted sm:px-8">
                <p>{{ __('common.app_name') }} · {{ __('auth.school_line') }}</p>
                <a href="{{ route('guide') }}" class="font-medium text-brand-700 hover:underline">{{ __('nav.guide') }}</a>
            </div>
        </footer>
    </body>
</html>
