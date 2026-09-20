<?php

namespace Tests\Feature;

use App\Enums\MessageRole;
use App\Models\Classroom;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\RoleplayScenario;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_dashboard_counts_only_their_own_practice(): void
    {
        $student = User::factory()->student()->create();
        $other = User::factory()->student()->create();
        $topic = Topic::factory()->create(['title_vi' => 'Mua sắm', 'title_en' => 'Shopping']);
        $scenario = RoleplayScenario::factory()->for($topic)->create(['title_vi' => 'Mua áo phông']);

        $mine = Conversation::factory()->for($student)->for($scenario, 'scenario')->create();
        ConversationMessage::factory()->count(3)->for($mine)->create(['role' => MessageRole::Student]);

        $theirs = Conversation::factory()->for($other)->for($scenario, 'scenario')->create();
        ConversationMessage::factory()->count(5)->for($theirs)->create(['role' => MessageRole::Student]);

        $this->actingAs($student)
            ->get(route('home'))
            ->assertOk()
            ->assertSeeInOrder(['Lượt nhập vai', '1'])
            ->assertSee('Mua áo phông');
    }

    public function test_student_dashboard_suggests_only_topics_not_yet_practised(): void
    {
        $student = User::factory()->student()->create();
        $practised = Topic::factory()->create(['title_vi' => 'Mua sắm']);
        $scenario = RoleplayScenario::factory()->for($practised)->create();
        Conversation::factory()->for($student)->for($scenario, 'scenario')->create();
        Topic::factory()->create(['title_vi' => 'Thời tiết']);

        $this->actingAs($student)
            ->get(route('home'))
            ->assertOk()
            ->assertSee('Thời tiết');
    }

    public function test_teacher_dashboard_shows_only_their_own_classes_and_students(): void
    {
        $teacher = User::factory()->teacher()->create();
        $classroom = Classroom::factory()->for($teacher, 'teacher')->create(['name' => '7A']);
        // Explicit content everywhere: faker text on the page could otherwise collide with the assertions.
        $topic = Topic::factory()->create(['title_vi' => 'Mua sắm', 'title_en' => 'Shopping']);
        $scenario = RoleplayScenario::factory()->for($topic)->create(['title_vi' => 'Mua áo phông']);

        $myStudent = User::factory()->student()->create(['name' => 'Nguyễn Văn An']);
        $classroom->students()->attach($myStudent);
        Conversation::factory()->for($myStudent)->for($scenario, 'scenario')->create();

        $otherClassroom = Classroom::factory()->create(['name' => '8B', 'grade' => 8]);
        $otherStudent = User::factory()->student()->create(['name' => 'Trần Quốc Bảo']);
        $otherClassroom->students()->attach($otherStudent);
        Conversation::factory()->for($otherStudent)->for($scenario, 'scenario')->create();

        $this->actingAs($teacher)
            ->get(route('home'))
            ->assertOk()
            ->assertSee('Nguyễn Văn An')
            ->assertSee('7A')
            ->assertDontSee('Trần Quốc Bảo')
            ->assertDontSee('8B');
    }

    public function test_student_dashboard_is_shown_to_students_not_the_teaching_one(): void
    {
        $student = User::factory()->student()->create();

        $this->actingAs($student)
            ->get(route('home'))
            ->assertOk()
            ->assertSee('Tiến độ của em')
            ->assertDontSee('Tổng quan lớp học');
    }

    public function test_guest_cannot_open_the_dashboard(): void
    {
        $this->get(route('home'))->assertRedirect(route('login'));
    }
}
