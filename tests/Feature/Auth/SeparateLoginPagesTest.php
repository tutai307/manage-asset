<?php

namespace Tests\Feature\Auth;

use App\Livewire\Auth\Login;
use App\Livewire\Auth\StaffLogin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SeparateLoginPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_each_page_says_who_it_is_for_and_links_to_the_other(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee(__('auth.welcome'))
            ->assertSee(route('login.staff'));

        $this->get(route('login.staff'))
            ->assertOk()
            ->assertSee(__('auth.staff_welcome'))
            ->assertSee(route('login'));
    }

    public function test_teacher_and_admin_sign_in_on_the_staff_page(): void
    {
        foreach ([User::factory()->teacher(), User::factory()->admin()] as $factory) {
            $user = $factory->create(['password' => 'secret-123']);

            Livewire::test(StaffLogin::class)
                ->set('username', $user->username)
                ->set('password', 'secret-123')
                ->call('login')
                ->assertHasNoErrors()
                ->assertRedirect(route('home'));

            $this->assertAuthenticatedAs($user);
            $this->post(route('logout'));
        }
    }

    public function test_student_is_refused_on_the_staff_page(): void
    {
        User::factory()->student()->create(['username' => 'hs.nguyenvanan', 'password' => 'secret-123']);

        Livewire::test(StaffLogin::class)
            ->set('username', 'hs.nguyenvanan')
            ->set('password', 'secret-123')
            ->call('login')
            ->assertHasErrors(['username'])
            ->assertSee(__('auth.failed'));

        $this->assertGuest();
    }

    public function test_teacher_and_admin_are_refused_on_the_student_page(): void
    {
        foreach ([User::factory()->teacher(), User::factory()->admin()] as $factory) {
            $user = $factory->create(['password' => 'secret-123']);

            Livewire::test(Login::class)
                ->set('username', $user->username)
                ->set('password', 'secret-123')
                ->call('login')
                ->assertHasErrors(['username']);

            $this->assertGuest();
        }
    }

    public function test_signing_out_returns_to_the_page_for_that_role(): void
    {
        $this->actingAs(User::factory()->teacher()->create())
            ->post(route('logout'))
            ->assertRedirect(route('login.staff'));

        $this->actingAs(User::factory()->student()->create())
            ->post(route('logout'))
            ->assertRedirect(route('login'));
    }

    public function test_a_signed_in_user_is_sent_home_from_the_staff_page(): void
    {
        $this->actingAs(User::factory()->teacher()->create())
            ->get(route('login.staff'))
            ->assertRedirect(route('home'));
    }
}
