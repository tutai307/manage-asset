<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_guest_sees_the_landing_page_with_both_sign_in_pages_and_the_guide(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Nói tiếng Anh mỗi ngày, có người luyện cùng')
            ->assertSee(route('login'))
            ->assertSee(route('login.staff'))
            ->assertSee(route('guide'));
    }

    public function test_a_signed_in_user_opening_the_address_of_the_site_goes_to_their_dashboard(): void
    {
        $student = User::factory()->create();

        $this->actingAs($student)->get('/')->assertRedirect(route('home'));
    }

    public function test_the_guide_can_be_read_without_an_account(): void
    {
        $response = $this->get(route('guide'));

        $response->assertOk()
            ->assertSee('Hướng dẫn sử dụng')
            ->assertSee('Gọi điện luyện nói với nhân vật')
            ->assertSee('Đặt lại mật khẩu cho giáo viên');
    }

    public function test_a_signed_in_user_reads_the_guide_and_is_offered_the_way_back_to_the_app(): void
    {
        $student = User::factory()->create();

        $this->actingAs($student)->get(route('guide'))
            ->assertOk()
            ->assertSee('Vào trang học')
            ->assertSee(route('home'));
    }

    public function test_the_guide_marks_button_names_in_bold(): void
    {
        $this->get(route('guide'))->assertSee('<strong>Lưu mật khẩu mới</strong>', false);
    }

    public function test_the_app_menu_and_the_sign_in_page_link_to_the_guide(): void
    {
        $this->get(route('login'))->assertSee(route('guide'));

        $this->actingAs(User::factory()->create())->get(route('home'))->assertSee(route('guide'));
    }

    public function test_english_mode_shows_the_public_pages_in_english(): void
    {
        $this->withSession(['locale' => 'en'])->get('/')
            ->assertSee('Speak English every day, with someone to practise with')
            ->assertDontSee('Nói tiếng Anh mỗi ngày');

        $this->withSession(['locale' => 'en'])->get(route('guide'))
            ->assertSee('User guide')
            ->assertSee('Calling a character to practise speaking')
            ->assertDontSee('Hướng dẫn sử dụng');
    }

    public function test_a_guest_can_switch_language_on_the_landing_page_and_stay_there(): void
    {
        $this->from('/')->post(route('locale.switch', 'en'))->assertRedirect('/');

        $this->get('/')->assertSee('Teacher sign-in');
    }

    public function test_every_public_text_exists_in_both_languages_with_the_same_structure(): void
    {
        foreach (['landing', 'guide'] as $file) {
            $this->assertSame(
                $this->shape(require lang_path("vi/{$file}.php")),
                $this->shape(require lang_path("en/{$file}.php")),
                "lang/vi/{$file}.php and lang/en/{$file}.php have different keys or list lengths",
            );
        }
    }

    public function test_every_guide_anchor_is_unique_so_the_contents_links_land_on_the_right_section(): void
    {
        $ids = [];

        foreach ((require lang_path('vi/guide.php'))['parts'] as $part) {
            $ids[] = $part['id'];
            array_push($ids, ...array_column($part['topics'], 'id'));
        }

        $this->assertSame(array_unique($ids), $ids);
    }

    /**
     * The same array with every text replaced, so only keys and list lengths are compared.
     *
     * @param  array<array-key, mixed>  $texts
     * @return array<array-key, mixed>
     */
    private function shape(array $texts): array
    {
        return array_map(fn (mixed $value) => is_array($value) ? $this->shape($value) : 'text', $texts);
    }
}
