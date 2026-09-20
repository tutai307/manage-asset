<?php

namespace Tests\Feature;

use App\Models\RoleplayScenario;
use App\Models\Topic;
use App\Models\User;
use Database\Seeders\StarterTopicSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;

class LocaleSwitchTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_uses_vietnamese_by_default(): void
    {
        $this->get(route('login'))->assertOk()->assertSee('Đăng nhập')->assertDontSee('Sign in');
    }

    public function test_guest_switches_the_interface_to_english(): void
    {
        $this->from(route('login'))
            ->post(route('locale.switch', 'en'))
            ->assertRedirect(route('login'));

        $this->get(route('login'))->assertSee('Sign in')->assertDontSee('Đăng nhập');
    }

    public function test_guest_switches_back_to_vietnamese(): void
    {
        $this->post(route('locale.switch', 'en'));
        $this->post(route('locale.switch', 'vi'));

        $this->get(route('login'))->assertSee('Đăng nhập');
    }

    public function test_unsupported_language_is_rejected(): void
    {
        $this->post('/locale/fr')->assertNotFound();

        $this->get(route('login'))->assertSee('Đăng nhập');
    }

    public function test_signed_in_users_choice_is_saved_to_their_account(): void
    {
        $student = User::factory()->student()->create(['locale' => null]);

        $this->actingAs($student)->post(route('locale.switch', 'en'));

        $this->assertDatabaseHas('users', ['id' => $student->id, 'locale' => 'en']);
    }

    public function test_saved_preference_applies_in_a_new_session(): void
    {
        $student = User::factory()->student()->create(['locale' => 'en']);

        $this->actingAs($student)->get(route('topics.index'))->assertSee('Topics')->assertDontSee('Chủ đề');
    }

    public function test_english_interface_shows_no_vietnamese_topic_or_scenario_text(): void
    {
        $this->seed(StarterTopicSeeder::class);
        $student = User::factory()->student()->create(['locale' => 'en']);
        $shopping = Topic::where('slug', 'shopping')->firstOrFail();

        $this->actingAs($student)
            ->get(route('topics.show', $shopping))
            ->assertOk()
            ->assertSee('Ask about prices, sizes and colours, and buy things in a shop.')
            ->assertDontSee('Mua sắm')
            ->assertDontSee('Hỏi giá, hỏi cỡ và màu sắc')
            ->assertSee('You go into a clothes shop and want to buy a T-shirt')
            ->assertDontSee('Em vào cửa hàng quần áo');
    }

    public function test_vietnamese_interface_shows_vietnamese_topic_and_scenario_text(): void
    {
        $this->seed(StarterTopicSeeder::class);
        $student = User::factory()->student()->create(['locale' => 'vi']);
        $shopping = Topic::where('slug', 'shopping')->firstOrFail();

        $this->actingAs($student)
            ->get(route('topics.show', $shopping))
            ->assertOk()
            ->assertSee('Mua sắm')
            ->assertSee('Hỏi giá, hỏi cỡ và màu sắc')
            ->assertSee('Em vào cửa hàng quần áo');
    }

    public function test_english_text_falls_back_to_vietnamese_when_missing(): void
    {
        $student = User::factory()->student()->create(['locale' => 'en']);
        $topic = Topic::factory()->create(['description_vi' => 'Chỉ có tiếng Việt', 'description_en' => null]);
        RoleplayScenario::factory()->for($topic)->create(['situation_vi' => 'Tình huống tiếng Việt', 'situation_en' => null]);

        $this->actingAs($student)
            ->get(route('topics.show', $topic))
            ->assertSee('Chỉ có tiếng Việt')
            ->assertSee('Tình huống tiếng Việt');
    }

    public function test_every_starter_topic_and_scenario_has_english_text(): void
    {
        $this->seed(StarterTopicSeeder::class);

        $this->assertSame(0, Topic::whereNull('description_en')->count());
        $this->assertSame(0, RoleplayScenario::whereNull('situation_en')->count());
    }

    public function test_every_translation_key_exists_in_both_languages(): void
    {
        foreach (['auth', 'common', 'classrooms', 'topics', 'roleplay', 'nav', 'dashboard', 'history', 'review', 'curriculum', 'skills'] as $file) {
            $vi = array_keys(Arr::dot(require lang_path("vi/{$file}.php")));
            $en = array_keys(Arr::dot(require lang_path("en/{$file}.php")));

            $this->assertEqualsCanonicalizing($vi, $en, "lang/{vi,en}/{$file}.php keys differ");
        }
    }
}
