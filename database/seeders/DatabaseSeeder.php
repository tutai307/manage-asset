<?php

namespace Database\Seeders;

use App\Actions\Classrooms\CreateStudentAccounts;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Demo dataset for local development and sprint reviews. Never run against production.
     */
    public function run(): void
    {
        $this->call([
            CurriculumUnitSeeder::class,
            UnitFocusSeeder::class,
            UnitExerciseSeeder::class,
            StarterTopicSeeder::class,
        ]);

        User::factory()->admin()->create(['name' => 'Quản trị', 'username' => 'admin']);

        $teacher = User::factory()->teacher()->create(['name' => 'Trần Thị Hoa', 'username' => 'gv.hoa']);

        $classroom = Classroom::factory()->for($teacher, 'teacher')->create(['name' => '7A', 'grade' => 7]);

        app(CreateStudentAccounts::class)->handle($classroom, ['Nguyễn Văn An', 'Lê Thị Bình', 'Phạm Minh Châu']);

        // Known password for the demo student: hs.nguyenvanan / password
        User::where('username', 'hs.nguyenvanan')->update(['password' => bcrypt('password')]);
    }
}
