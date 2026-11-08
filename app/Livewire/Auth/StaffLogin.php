<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;

/**
 * The sign-in page for teachers and administrators. AM-032.
 */
#[Layout('layouts::guest')]
class StaffLogin extends Login
{
    protected function forStaff(): bool
    {
        return true;
    }
}
