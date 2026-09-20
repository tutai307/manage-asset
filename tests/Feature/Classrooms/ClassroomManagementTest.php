<?php

namespace Tests\Feature\Classrooms;

use App\Enums\UserRole;
use App\Livewire\Classrooms\Index;
use App\Livewire\Classrooms\Show;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class ClassroomManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_creates_a_class(): void
    {
        $teacher = User::factory()->teacher()->create(['name' => 'Trần Thị Hoa']);

        Livewire::actingAs($teacher)
            ->test(Index::class)
            ->set('name', '7A')
            ->set('grade', 7)
            ->call('create')
            ->assertHasNoErrors()
            ->assertDispatched('notify')
            ->assertSee('7A');

        $this->assertDatabaseHas('classrooms', ['teacher_id' => $teacher->id, 'name' => '7A', 'grade' => 7]);
    }

    public function test_duplicate_class_name_for_the_same_teacher_is_refused(): void
    {
        $teacher = User::factory()->teacher()->create();
        Classroom::factory()->for($teacher, 'teacher')->create(['name' => '7A']);

        Livewire::actingAs($teacher)
            ->test(Index::class)
            ->set('name', '7A')
            ->call('create')
            ->assertHasErrors(['name'])
            ->assertSee('Lớp này đã tồn tại');

        $this->assertDatabaseCount('classrooms', 1);
    }

    public function test_another_teacher_may_use_the_same_class_name(): void
    {
        Classroom::factory()->create(['name' => '7A']);
        $teacher = User::factory()->teacher()->create();

        Livewire::actingAs($teacher)
            ->test(Index::class)
            ->set('name', '7A')
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseCount('classrooms', 2);
    }

    public function test_teacher_sees_only_their_own_classes_in_the_list(): void
    {
        $teacher = User::factory()->teacher()->create();
        Classroom::factory()->for($teacher, 'teacher')->create(['name' => '7A']);
        Classroom::factory()->create(['name' => '8B']);

        Livewire::actingAs($teacher)
            ->test(Index::class)
            ->assertSee('7A')
            ->assertDontSee('8B');
    }

    public function test_teacher_cannot_open_another_teachers_class(): void
    {
        $teacher = User::factory()->teacher()->create();
        $otherClass = Classroom::factory()->create(['name' => '8B']);

        $this->actingAs($teacher)->get(route('classrooms.show', $otherClass))->assertForbidden();
    }

    public function test_admin_can_open_any_class(): void
    {
        $admin = User::factory()->admin()->create();
        $classroom = Classroom::factory()->create(['name' => '8B']);

        $this->actingAs($admin)->get(route('classrooms.show', $classroom))->assertOk()->assertSee('8B');
    }

    public function test_student_cannot_create_a_class(): void
    {
        $student = User::factory()->student()->create();

        Livewire::actingAs($student)->test(Index::class)->assertForbidden();

        $this->assertDatabaseCount('classrooms', 0);
    }

    public function test_teacher_adds_students_and_receives_printable_credentials(): void
    {
        $teacher = User::factory()->teacher()->create();
        $classroom = Classroom::factory()->for($teacher, 'teacher')->create(['name' => '7A']);

        $component = Livewire::actingAs($teacher)
            ->test(Show::class, ['classroom' => $classroom])
            ->set('studentNames', "Nguyễn Văn An\n  Lê Thị Bình  \n\n")
            ->call('addStudents')
            ->assertHasNoErrors()
            ->assertSee('hs.nguyenvanan')
            ->assertSee('hs.lethibinh');

        $credentials = $component->get('credentials');
        $this->assertCount(2, $credentials);

        $an = User::where('username', 'hs.nguyenvanan')->firstOrFail();
        $this->assertSame('Nguyễn Văn An', $an->name);
        $this->assertSame(UserRole::Student, $an->role);
        $this->assertTrue($classroom->students()->whereKey($an->id)->exists());
        $this->assertTrue(Hash::check($credentials[0]['password'], $an->password));
        $this->assertTrue(Auth::validate(['username' => 'hs.nguyenvanan', 'password' => $credentials[0]['password']]));
    }

    public function test_duplicate_student_names_get_distinct_usernames(): void
    {
        $teacher = User::factory()->teacher()->create();
        $classroom = Classroom::factory()->for($teacher, 'teacher')->create();
        User::factory()->student()->create(['username' => 'hs.nguyenvanan']);

        Livewire::actingAs($teacher)
            ->test(Show::class, ['classroom' => $classroom])
            ->set('studentNames', "Nguyễn Văn An\nNguyễn Văn An")
            ->call('addStudents')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('users', ['username' => 'hs.nguyenvanan2']);
        $this->assertDatabaseHas('users', ['username' => 'hs.nguyenvanan3']);
    }

    public function test_student_name_list_is_required(): void
    {
        $teacher = User::factory()->teacher()->create();
        $classroom = Classroom::factory()->for($teacher, 'teacher')->create();

        Livewire::actingAs($teacher)
            ->test(Show::class, ['classroom' => $classroom])
            ->set('studentNames', '')
            ->call('addStudents')
            ->assertHasErrors(['studentNames']);

        $this->assertDatabaseCount('classroom_user', 0);
    }

    public function test_teacher_resets_a_students_password(): void
    {
        $teacher = User::factory()->teacher()->create();
        $classroom = Classroom::factory()->for($teacher, 'teacher')->create();
        $student = User::factory()->student()->create(['password' => 'old-password']);
        $classroom->students()->attach($student);

        $component = Livewire::actingAs($teacher)
            ->test(Show::class, ['classroom' => $classroom])
            ->call('resetPassword', $student->id);

        $newPassword = $component->get('credentials')[0]['password'];
        $this->assertTrue(Hash::check($newPassword, $student->fresh()->password));
    }

    public function test_teacher_cannot_reset_password_of_a_student_outside_the_class(): void
    {
        $teacher = User::factory()->teacher()->create();
        $classroom = Classroom::factory()->for($teacher, 'teacher')->create();
        $outsider = User::factory()->student()->create(['password' => 'old-password']);

        $component = Livewire::actingAs($teacher)->test(Show::class, ['classroom' => $classroom]);

        $this->assertThrows(
            fn () => $component->call('resetPassword', $outsider->id),
            ModelNotFoundException::class,
        );

        $this->assertTrue(Hash::check('old-password', $outsider->fresh()->password));
    }
}
