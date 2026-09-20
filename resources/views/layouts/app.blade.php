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
    <body class="min-h-screen bg-ground font-sans text-ink antialiased" x-data="{ sidebarOpen: false }" x-on:keydown.escape.window="sidebarOpen = false">
        @php($user = auth()->user())

        <div x-show="sidebarOpen" x-cloak x-transition.opacity x-on:click="sidebarOpen = false"
            class="fixed inset-0 z-30 bg-ink/30 lg:hidden"></div>

        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-40 flex w-68 flex-col border-r border-line bg-surface transition-transform duration-200 lg:translate-x-0"
            x-bind:class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            aria-label="{{ __('common.main_nav') }}">

            <div class="flex items-center justify-between gap-3 border-b border-line px-5 py-4">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 rounded-lg focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600">
                    <span class="grid size-9 place-items-center rounded-lg bg-brand-600 text-sm font-bold text-white">EB</span>
                    <span class="text-base font-bold">{{ __('common.app_name') }}</span>
                </a>
                <button type="button" class="rounded-lg p-2 text-ink-muted hover:bg-ground lg:hidden" x-on:click="sidebarOpen = false" aria-label="{{ __('nav.close_menu') }}">
                    <x-icon name="x" />
                </button>
            </div>

            <nav class="flex-1 space-y-6 overflow-y-auto px-3 py-5">
                <div class="space-y-0.5">
                    <p class="label-eyebrow px-3 pb-2">{{ __('nav.section_learn') }}</p>
                    <x-nav-link :href="route('home')" icon="home" :active="request()->routeIs('home')">{{ __('nav.dashboard') }}</x-nav-link>
                    <x-nav-link :href="route('curriculum.index')" icon="academic" :active="request()->routeIs('curriculum.*')">{{ __('nav.curriculum') }}</x-nav-link>
                    <x-nav-link :href="route('topics.index')" icon="book" :active="request()->routeIs('topics.*')">{{ __('nav.topics') }}</x-nav-link>
                    <x-nav-link :href="route('conversations.index')" icon="chat" :active="request()->routeIs('conversations.*')">{{ __('nav.conversations') }}</x-nav-link>
                </div>

                @can('viewAny', App\Models\Classroom::class)
                    <div class="space-y-0.5">
                        <p class="label-eyebrow px-3 pb-2">{{ __('nav.section_teach') }}</p>
                        <x-nav-link :href="route('classrooms.index')" icon="users" :active="request()->routeIs('classrooms.*')">{{ __('nav.classrooms') }}</x-nav-link>
                    </div>
                @endcan
            </nav>

            <div class="border-t border-line p-3">
                <div class="flex items-center justify-between gap-2 px-2 pb-3">
                    <span class="text-xs font-medium text-ink-subtle">{{ __('common.language') }}</span>
                    <x-locale-switcher />
                </div>

                <div class="flex items-center gap-3 rounded-lg px-2 py-2">
                    <span class="grid size-9 shrink-0 place-items-center rounded-full bg-brand-50 text-sm font-semibold text-brand-700">
                        {{ mb_strtoupper(mb_substr(Illuminate\Support\Str::afterLast($user->name, ' '), 0, 1)) }}
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-semibold">{{ $user->name }}</p>
                        <p class="truncate text-xs text-ink-subtle">{{ $user->role->label() }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-lg p-2 text-ink-subtle transition hover:bg-ground hover:text-bad" title="{{ __('auth.sign_out') }}" aria-label="{{ __('auth.sign_out') }}">
                            <x-icon name="logout" />
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="lg:pl-68">
            <header class="sticky top-0 z-20 flex items-center gap-3 border-b border-line bg-surface px-4 py-3 lg:hidden">
                <button type="button" class="rounded-lg p-2 text-ink-muted hover:bg-ground" x-on:click="sidebarOpen = true"
                    aria-controls="sidebar" x-bind:aria-expanded="sidebarOpen" aria-label="{{ __('nav.open_menu') }}">
                    <x-icon name="menu" class="size-6" />
                </button>
                <span class="font-bold">{{ __('common.app_name') }}</span>
            </header>

            <main class="mx-auto max-w-5xl px-4 py-8 sm:px-8 sm:py-10">
                {{ $slot }}
            </main>
        </div>

        {{-- The single notification mechanism: components dispatch "notify". --}}
        <div
            x-data="{ show: false, message: '', timer: null }"
            x-on:notify.window="message = $event.detail.message; show = true; clearTimeout(timer); timer = setTimeout(() => show = false, 4000)"
            x-show="show"
            x-cloak
            x-transition
            role="status"
            aria-live="polite"
            class="fixed right-4 bottom-4 z-50 flex max-w-sm items-center gap-2.5 rounded-lg border border-line bg-surface px-4 py-3 text-sm font-medium shadow-lg"
        >
            <x-icon name="check" class="size-5 text-good" />
            <span x-text="message"></span>
        </div>

        @livewireScripts
    </body>
</html>
