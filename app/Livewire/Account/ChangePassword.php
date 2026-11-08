<?php

namespace App\Livewire\Account;

use App\Actions\Accounts\ChangeOwnPassword;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChangePassword extends Component
{
    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function save(ChangeOwnPassword $changeOwnPassword): void
    {
        $this->validate(
            [
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', 'min:8', 'max:255', 'confirmed', 'different:current_password'],
            ],
            attributes: [
                'current_password' => __('account.current_password'),
                'password' => __('account.new_password'),
            ],
        );

        $changeOwnPassword->handle(Auth::user(), $this->password);

        $this->reset('current_password', 'password', 'password_confirmation');
        $this->dispatch('notify', message: __('account.password_changed'));
    }

    public function render()
    {
        return view('livewire.account.change-password')->title(__('account.change_password'));
    }
}
