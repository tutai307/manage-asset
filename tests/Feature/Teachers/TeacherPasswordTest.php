<?php

namespace Tests\Feature\Teachers;

use App\Livewire\Teachers\Index;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class TeacherPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_an_administrator_opens_the_teacher_list(): void
    {
        $this->actingAs(User::factory()->admin()->create())->get(route('teachers.index'))->assertOk();
        $this->actingAs(User::factory()->teacher()->create())->get(route('teachers.index'))->assertForbidden();
        $this->actingAs(User::factory()->student()->create())->get(route('teachers.index'))->assertForbidden();
    }

    public function test_the_sidebar_link_is_for_administrators_only(): void
    {
        $this->actingAs(User::factory()->admin()->create())->get(route('home'))->assertSee(route('teachers.index'));
        $this->actingAs(User::factory()->teacher()->create())->get(route('home'))->assertDontSee(route('teachers.index'));
    }

    public function test_the_list_shows_teachers_only(): void
    {
        $teacher = User::factory()->teacher()->create(['username' => 'gv.hoa']);
        User::factory()->student()->create(['username' => 'hs.nguyenvanan']);

        Livewire::actingAs(User::factory()->admin()->create())
            ->test(Index::class)
            ->assertSee($teacher->username)
            ->assertDontSee('hs.nguyenvanan');
    }

    public function test_an_administrator_resets_a_teachers_password_and_sees_it_once(): void
    {
        $teacher = User::factory()->teacher()->create(['password' => 'old-secret-1']);

        $component = Livewire::actingAs(User::factory()->admin()->create())
            ->test(Index::class)
            ->call('resetPassword', $teacher->id)
            ->assertDispatched('notify');

        $password = $component->get('credentials')[0]['password'];

        $component->assertSee($password);
        $this->assertTrue(Hash::check($password, $teacher->fresh()->password));
        $this->assertFalse(Hash::check('old-secret-1', $teacher->fresh()->password));

        Livewire::actingAs(User::factory()->admin()->create())
            ->test(Index::class)
            ->assertDontSee($password);
    }

    public function test_an_administrator_cannot_reset_a_student_or_another_administrator_here(): void
    {
        $admin = User::factory()->admin()->create();

        foreach ([User::factory()->student(), User::factory()->admin()] as $factory) {
            $target = $factory->create(['password' => 'old-secret-1']);

            Livewire::actingAs($admin)
                ->test(Index::class)
                ->call('resetPassword', $target->id)
                ->assertForbidden();

            $this->assertTrue(Hash::check('old-secret-1', $target->fresh()->password));
        }
    }

    public function test_a_teacher_cannot_reset_another_teachers_password(): void
    {
        $teacher = User::factory()->teacher()->create();

        Livewire::actingAs($teacher)
            ->test(Index::class)
            ->assertForbidden();
    }
}
