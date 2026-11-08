<?php

namespace App\Livewire\Auth;

use App\Enums\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts::guest')]
class Login extends Component
{
    public const MAX_ATTEMPTS = 5;

    #[Validate('required|string|max:50')]
    public string $username = '';

    #[Validate('required|string|max:255')]
    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $this->validate();

        $key = $this->throttleKey();

        if (RateLimiter::tooManyAttempts($key, self::MAX_ATTEMPTS)) {
            throw ValidationException::withMessages([
                'username' => __('auth.throttle', ['seconds' => RateLimiter::availableIn($key)]),
            ]);
        }

        if (! Auth::attempt(['username' => $this->username, 'password' => $this->password, 'role' => $this->acceptedRoles()], $this->remember)) {
            RateLimiter::hit($key, 60);
            $this->reset('password');

            throw ValidationException::withMessages(['username' => __('auth.failed')]);
        }

        RateLimiter::clear($key);
        session()->regenerate();

        $this->redirectIntended(route('home'), navigate: false);
    }

    public function render()
    {
        return view('livewire.auth.login', ['staff' => $this->forStaff()])
            ->title(__($this->forStaff() ? 'auth.staff_welcome' : 'auth.welcome'));
    }

    protected function forStaff(): bool
    {
        return false;
    }

    /**
     * An account from the other sign-in page gets the same refusal as a wrong password.
     *
     * @return list<string>
     */
    private function acceptedRoles(): array
    {
        return collect(UserRole::cases())
            ->filter(fn (UserRole $role) => $role->canTeach() === $this->forStaff())
            ->map(fn (UserRole $role) => $role->value)
            ->values()
            ->all();
    }

    private function throttleKey(): string
    {
        return Str::lower($this->username).'|'.request()->ip();
    }
}
