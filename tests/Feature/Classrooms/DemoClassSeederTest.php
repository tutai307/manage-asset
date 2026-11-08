<?php

namespace Tests\Feature\Classrooms;

use App\Enums\UserRole;
use App\Models\Classroom;
use App\Models\User;
use Database\Seeders\DemoClassSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DemoClassSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_one_admin_one_teacher_and_a_class_of_thirty_students(): void
    {
        $this->seed(DemoClassSeeder::class);

        $this->assertSame(1, User::where('role', UserRole::Admin->value)->count());
        $this->assertSame(1, User::where('role', UserRole::Teacher->value)->count());

        $classroom = Classroom::where('name', '6A')->sole();

        $this->assertSame(6, $classroom->grade);
        $this->assertSame('gv.giaovien', $classroom->teacher->username);
        $this->assertSame(30, $classroom->students()->count());
    }

    public function test_student_usernames_follow_the_persons_name(): void
    {
        $this->seed(DemoClassSeeder::class);

        $this->assertDatabaseHas('users', ['name' => 'Trần Gia Bảo', 'username' => 'hs.trangiabao']);
        $this->assertDatabaseHas('users', ['name' => 'Đỗ Tuấn Kiệt', 'username' => 'hs.dotuankiet']);
    }

    public function test_no_account_gets_a_guessable_password(): void
    {
        $this->seed(DemoClassSeeder::class);

        User::all()->each(fn (User $user) => $this->assertFalse(Hash::check('password', $user->password), $user->username));
    }

    public function test_running_twice_creates_nothing_new_and_keeps_every_password(): void
    {
        $this->seed(DemoClassSeeder::class);
        $before = User::orderBy('id')->pluck('password', 'username')->all();

        $this->seed(DemoClassSeeder::class);

        $this->assertSame($before, User::orderBy('id')->pluck('password', 'username')->all());
        $this->assertSame(1, Classroom::where('name', '6A')->count());
    }

    public function test_existing_staff_accounts_are_reused_with_their_password(): void
    {
        $admin = User::factory()->admin()->create(['username' => 'admin', 'password' => 'chosen-by-admin']);
        $teacher = User::factory()->teacher()->create(['username' => 'gv.giaovien', 'password' => 'chosen-by-teacher']);

        $this->seed(DemoClassSeeder::class);

        $this->assertTrue(Hash::check('chosen-by-admin', $admin->fresh()->password));
        $this->assertTrue(Hash::check('chosen-by-teacher', $teacher->fresh()->password));
        $this->assertSame($teacher->id, Classroom::where('name', '6A')->sole()->teacher_id);
    }

    public function test_a_missing_student_is_added_without_touching_the_others(): void
    {
        $this->seed(DemoClassSeeder::class);
        $classroom = Classroom::where('name', '6A')->sole();
        $student = User::where('username', 'hs.trangiabao')->sole();
        $classroom->students()->detach($student->id);
        $student->forceDelete();
        $other = User::where('username', 'hs.nguyenhoanganh')->sole()->password;

        $this->seed(DemoClassSeeder::class);

        $this->assertSame(30, $classroom->students()->count());
        $this->assertSame($other, User::where('username', 'hs.nguyenhoanganh')->sole()->password);
    }
}
