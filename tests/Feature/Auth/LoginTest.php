<?php

namespace Tests\Feature\Auth;

use App\Livewire\Auth\Login;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_the_login_page(): void
    {
        $this->get('/topics')->assertRedirect(route('login'));
    }

    public function test_login_page_renders(): void
    {
        $this->get(route('login'))->assertOk()->assertSee('Đăng nhập');
    }

    public function test_student_signs_in_with_username_and_lands_on_topics(): void
    {
        $student = User::factory()->student()->create(['username' => 'hs.nguyenvanan', 'password' => 'secret-123']);

        Livewire::test(Login::class)
            ->set('username', 'hs.nguyenvanan')
            ->set('password', 'secret-123')
            ->call('login')
            ->assertHasNoErrors()
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($student);
        $this->get(route('home'))->assertOk()->assertSee('Tiến độ của em');
    }

    public function test_teacher_sees_the_teaching_dashboard(): void
    {
        $teacher = User::factory()->teacher()->create();

        $this->actingAs($teacher)
            ->get(route('home'))
            ->assertOk()
            ->assertSee('Tổng quan lớp học')
            ->assertSee(__('classrooms.title'));
    }

    public function test_wrong_password_is_refused_with_vietnamese_message(): void
    {
        User::factory()->student()->create(['username' => 'hs.nguyenvanan', 'password' => 'secret-123']);

        Livewire::test(Login::class)
            ->set('username', 'hs.nguyenvanan')
            ->set('password', 'wrong')
            ->call('login')
            ->assertHasErrors(['username'])
            ->assertSee('Tên đăng nhập hoặc mật khẩu không đúng');

        $this->assertGuest();
    }

    public function test_sign_in_is_throttled_after_five_failed_attempts(): void
    {
        User::factory()->student()->create(['username' => 'hs.nguyenvanan', 'password' => 'secret-123']);

        $component = Livewire::test(Login::class)->set('username', 'hs.nguyenvanan');

        foreach (range(1, Login::MAX_ATTEMPTS) as $attempt) {
            $component->set('password', 'wrong')->call('login');
        }

        $component->set('password', 'secret-123')
            ->call('login')
            ->assertHasErrors(['username'])
            ->assertSee('Đăng nhập sai quá nhiều lần');

        $this->assertGuest();
    }

    public function test_soft_deleted_student_cannot_sign_in(): void
    {
        $student = User::factory()->student()->create(['username' => 'hs.daxoa', 'password' => 'secret-123']);
        $student->delete();

        Livewire::test(Login::class)
            ->set('username', 'hs.daxoa')
            ->set('password', 'secret-123')
            ->call('login')
            ->assertHasErrors(['username']);

        $this->assertGuest();
    }

    public function test_student_cannot_open_the_class_management_page(): void
    {
        $student = User::factory()->student()->create();

        $this->actingAs($student)->get(route('classrooms.index'))->assertForbidden();
    }

    public function test_user_can_sign_out(): void
    {
        $student = User::factory()->student()->create();

        $this->actingAs($student)->post(route('logout'))->assertRedirect(route('login'));

        $this->assertGuest();
    }
}
