<?php

namespace Database\Seeders;

use App\Actions\Classrooms\CreateStudentAccounts;
use App\Enums\UserRole;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * One administrator, one teacher and a made-up class 6A of 30 students (AM-002).
 *
 * The student names are invented placeholders; real pupils' names never belong in this file.
 *
 * Safe on production and non-destructive: accounts that already exist keep their password, and
 * re-running creates only what is missing. New passwords are random and printed once.
 */
class DemoClassSeeder extends Seeder
{
    private const STUDENT_NAMES = [
        'Trần Gia Bảo', 'Nguyễn Hoàng Anh', 'Lê Minh Khang', 'Phạm Thu Hà', 'Hoàng Đức Long',
        'Vũ Ngọc Linh', 'Đặng Quốc Huy', 'Bùi Phương Thảo', 'Đỗ Tuấn Kiệt', 'Hồ Thanh Trúc',
        'Ngô Nhật Minh', 'Dương Khánh Vy', 'Lý Hải Đăng', 'Mai Bảo Ngọc', 'Trịnh Anh Dũng',
        'Đinh Thùy Dương', 'Phan Gia Hưng', 'Võ Mỹ Duyên', 'Tô Đình Phúc', 'Cao Hà My',
        'Lương Thế Vinh', 'Tạ Minh Anh', 'Đoàn Quang Khải', 'Hà Thảo Nguyên', 'Chu Đức Thắng',
        'Nghiêm Tú Uyên', 'Kiều Trung Hiếu', 'Thái An Nhiên', 'Quách Bảo Lâm', 'La Diệu Linh',
    ];

    /**
     * @var list<array{0: string, 1: string, 2: string}>
     */
    private array $newAccounts = [];

    public function run(): void
    {
        DB::transaction(function () {
            $this->ensureStaffAccount('admin', 'Quản trị', UserRole::Admin);
            $teacher = $this->ensureStaffAccount('gv.giaovien', 'Giáo viên', UserRole::Teacher);

            $classroom = Classroom::firstOrCreate(
                ['teacher_id' => $teacher->id, 'name' => '6A'],
                ['grade' => 6],
            );

            $enrolled = $classroom->students()->withTrashed()->pluck('name')->all();
            $missing = array_values(array_diff(self::STUDENT_NAMES, $enrolled));

            foreach (app(CreateStudentAccounts::class)->handle($classroom, $missing) as $student) {
                $this->newAccounts[] = [$student['name'], $student['username'], $student['password']];
            }
        });

        if ($this->newAccounts === []) {
            $this->command?->info('Nothing to create: every account already exists.');

            return;
        }

        $this->command?->warn('Save these passwords now. They are not shown again.');
        $this->command?->table(['Name', 'Username', 'Password'], $this->newAccounts);
    }

    private function ensureStaffAccount(string $username, string $name, UserRole $role): User
    {
        $existing = User::withTrashed()->where('username', $username)->first();

        if ($existing !== null) {
            return $existing;
        }

        $password = Str::password(12, symbols: false);
        $this->newAccounts[] = [$name, $username, $password];

        return User::create([
            'name' => $name,
            'username' => $username,
            'password' => $password,
            'role' => $role,
        ]);
    }
}
