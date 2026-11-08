<div class="space-y-8">
    <header class="border-b border-line pb-6">
        <h1 class="text-2xl font-bold tracking-tight">{{ __('teachers.title') }}</h1>
        <p class="mt-1 text-sm text-ink-muted">{{ __('teachers.subtitle') }}</p>
    </header>

    @if ($credentials)
        {{-- Shown once, then gone: the only place these passwords are readable. --}}
        <section class="card border-warn/40 bg-warn-soft p-5">
            <h2 class="font-semibold">{{ __('teachers.credentials_title') }}</h2>
            <p class="mt-1 text-sm text-ink-muted">{{ __('teachers.credentials_hint') }}</p>

            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <caption class="sr-only">{{ __('teachers.credentials_title') }}</caption>
                    <thead class="text-xs text-ink-muted">
                        <tr>
                            <th scope="col" class="py-2 pr-4 font-medium">{{ __('teachers.name') }}</th>
                            <th scope="col" class="py-2 pr-4 font-medium">{{ __('auth.username') }}</th>
                            <th scope="col" class="py-2 font-medium">{{ __('auth.password_label') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-warn/20">
                        @foreach ($credentials as $i => $row)
                            <tr wire:key="credential-{{ $i }}">
                                <td class="py-2 pr-4">{{ $row['name'] }}</td>
                                <td class="py-2 pr-4 font-mono">{{ $row['username'] }}</td>
                                <td class="py-2 font-mono font-semibold">{{ $row['password'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    @endif

    @if ($teachers->isEmpty())
        <p class="card p-8 text-center text-sm text-ink-muted">{{ __('teachers.none') }}</p>
    @else
        <div class="card overflow-x-auto">
            <table class="w-full text-left text-sm">
                <caption class="sr-only">{{ __('teachers.title') }}</caption>
                <thead class="border-b border-line text-xs text-ink-subtle">
                    <tr>
                        <th scope="col" class="px-5 py-3 font-medium">{{ __('teachers.name') }}</th>
                        <th scope="col" class="px-5 py-3 font-medium">{{ __('auth.username') }}</th>
                        <th scope="col" class="px-5 py-3"><span class="sr-only">{{ __('common.actions') }}</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @foreach ($teachers as $teacher)
                        <tr wire:key="teacher-{{ $teacher->id }}">
                            <td class="px-5 py-3 font-medium">{{ $teacher->name }}</td>
                            <td class="px-5 py-3 font-mono text-ink-muted">{{ $teacher->username }}</td>
                            <td class="px-5 py-3 text-right">
                                <button type="button"
                                    wire:click="resetPassword({{ $teacher->id }})"
                                    wire:confirm="{{ __('teachers.reset_password_confirm', ['name' => $teacher->name]) }}"
                                    class="btn-quiet">
                                    <x-icon name="key" class="size-4" /> {{ __('teachers.reset_password') }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>{{ $teachers->links() }}</div>
    @endif
</div>
