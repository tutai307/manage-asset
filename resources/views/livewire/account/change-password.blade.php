<div class="space-y-8">
    <header class="border-b border-line pb-6">
        <h1 class="text-2xl font-bold tracking-tight">{{ __('account.change_password') }}</h1>
        <p class="mt-1 text-sm text-ink-muted">{{ __('account.change_password_hint') }}</p>
    </header>

    <form wire:submit="save" class="card max-w-md space-y-5 p-6">
        <div>
            <label for="current_password" class="mb-1.5 block text-sm font-medium">{{ __('account.current_password') }}</label>
            <input wire:model="current_password" id="current_password" type="password" autocomplete="current-password" class="form-input">
            @error('current_password') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="mb-1.5 block text-sm font-medium">{{ __('account.new_password') }}</label>
            <input wire:model="password" id="password" type="password" autocomplete="new-password" class="form-input">
            @error('password') <p class="mt-1.5 text-sm text-bad">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="mb-1.5 block text-sm font-medium">{{ __('account.confirm_password') }}</label>
            <input wire:model="password_confirmation" id="password_confirmation" type="password" autocomplete="new-password" class="form-input">
        </div>

        <button type="submit" wire:loading.attr="disabled" wire:target="save" class="btn-primary">
            {{ __('account.save_password') }}
        </button>
    </form>
</div>
