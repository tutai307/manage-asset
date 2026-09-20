<div class="card p-8">
    <div class="mb-6 flex items-center gap-2.5 lg:hidden">
        <span class="grid size-9 place-items-center rounded-lg bg-brand-600 text-sm font-bold text-white">EB</span>
        <span class="text-base font-bold">{{ __('common.app_name') }}</span>
    </div>

    <h1 class="text-2xl font-bold tracking-tight">{{ __('auth.welcome') }}</h1>
    <p class="mt-1.5 text-sm text-ink-muted">{{ __('auth.tagline') }}</p>

    <form wire:submit="login" class="mt-8 space-y-5">
        <div>
            <label for="username" class="mb-1.5 block text-sm font-medium">{{ __('auth.username') }}</label>
            <input wire:model="username" id="username" type="text" autocomplete="username" autofocus placeholder="hs.nguyenvanan" class="form-input">
            @error('username') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="mb-1.5 block text-sm font-medium">{{ __('auth.password_label') }}</label>
            <input wire:model="password" id="password" type="password" autocomplete="current-password" class="form-input">
            @error('password') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
        </div>

        <label class="flex items-center gap-2 text-sm text-ink-muted">
            <input wire:model="remember" type="checkbox" class="size-4 rounded border-line-strong text-brand-600 focus:ring-brand-100">
            {{ __('auth.remember') }}
        </label>

        <button type="submit" wire:loading.attr="disabled" wire:target="login" class="btn-primary w-full">
            <span wire:loading.remove wire:target="login">{{ __('auth.sign_in') }}</span>
            <span wire:loading wire:target="login">{{ __('auth.signing_in') }}</span>
        </button>
    </form>

    <p class="mt-6 border-t border-line pt-5 text-sm text-ink-muted">{{ __('auth.account_hint') }}</p>
</div>
