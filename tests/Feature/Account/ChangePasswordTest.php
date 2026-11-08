<?php

namespace Tests\Feature\Account;

use App\Livewire\Account\ChangePassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_guest_cannot_open_the_page(): void
    {
        $this->get(route('account.password'))->assertRedirect(route('login'));
    }

    public function test_student_changes_their_own_password(): void
    {
        $student = User::factory()->student()->create(['password' => 'old-secret-1']);

        $this->actingAs($student)->get(route('account.password'))->assertOk()->assertSee(__('nav.change_password'));

        Livewire::actingAs($student)
            ->test(ChangePassword::class)
            ->set('current_password', 'old-secret-1')
            ->set('password', 'new-secret-2')
            ->set('password_confirmation', 'new-secret-2')
            ->call('save')
            ->assertHasNoErrors()
            ->assertSet('current_password', '')
            ->assertSet('password', '')
            ->assertDispatched('notify');

        $this->assertTrue(Hash::check('new-secret-2', $student->fresh()->password));
    }

    public function test_a_teacher_can_change_their_own_password_too(): void
    {
        $teacher = User::factory()->teacher()->create(['password' => 'old-secret-1']);

        Livewire::actingAs($teacher)
            ->test(ChangePassword::class)
            ->set('current_password', 'old-secret-1')
            ->set('password', 'new-secret-2')
            ->set('password_confirmation', 'new-secret-2')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertTrue(Hash::check('new-secret-2', $teacher->fresh()->password));
    }

    /**
     * @return array<string, array{0: string, 1: string, 2: string, 3: string}>
     */
    public static function refusedChanges(): array
    {
        return [
            'wrong current password' => ['not-my-password', 'new-secret-2', 'new-secret-2', 'current_password'],
            'too short' => ['old-secret-1', 'short', 'short', 'password'],
            'confirmation differs' => ['old-secret-1', 'new-secret-2', 'other-secret-3', 'password'],
            'same as the old one' => ['old-secret-1', 'old-secret-1', 'old-secret-1', 'password'],
        ];
    }

    #[DataProvider('refusedChanges')]
    public function test_a_bad_change_is_refused_and_the_password_stays(string $current, string $new, string $confirmation, string $errorField): void
    {
        $student = User::factory()->student()->create(['password' => 'old-secret-1']);

        Livewire::actingAs($student)
            ->test(ChangePassword::class)
            ->set('current_password', $current)
            ->set('password', $new)
            ->set('password_confirmation', $confirmation)
            ->call('save')
            ->assertHasErrors([$errorField]);

        $this->assertTrue(Hash::check('old-secret-1', $student->fresh()->password));
    }

    public function test_the_refusal_is_in_vietnamese(): void
    {
        $student = User::factory()->student()->create(['password' => 'old-secret-1']);

        Livewire::actingAs($student)
            ->test(ChangePassword::class)
            ->set('current_password', 'not-my-password')
            ->set('password', 'new-secret-2')
            ->set('password_confirmation', 'new-secret-2')
            ->call('save')
            ->assertSee('Mật khẩu hiện tại không đúng.');
    }

    public function test_it_only_changes_the_signed_in_account(): void
    {
        $student = User::factory()->student()->create(['password' => 'old-secret-1']);
        $classmate = User::factory()->student()->create(['password' => 'classmate-secret']);

        Livewire::actingAs($student)
            ->test(ChangePassword::class)
            ->set('current_password', 'old-secret-1')
            ->set('password', 'new-secret-2')
            ->set('password_confirmation', 'new-secret-2')
            ->call('save');

        $this->assertTrue(Hash::check('classmate-secret', $classmate->fresh()->password));
    }
}
