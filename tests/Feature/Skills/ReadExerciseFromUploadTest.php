<?php

namespace Tests\Feature\Skills;

use App\Enums\ExerciseSource;
use App\Enums\QuestionType;
use App\Livewire\Skills\CreateExercise;
use App\Models\SkillExercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class ReadExerciseFromUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');
    }

    private function fakeReading(array $payload): void
    {
        Http::fake(['openrouter.ai/*' => Http::response(['choices' => [['message' => ['content' => json_encode($payload)]]]])]);
    }

    private function readTest(): array
    {
        return [
            'title_en' => 'Unit 3 quiz', 'title_vi' => 'Kiểm tra Unit 3',
            'instructions_en' => 'Answer all questions.', 'instructions_vi' => 'Làm tất cả các câu.',
            'passage' => null,
            'questions' => [
                ['type' => 'multiple_choice', 'prompt' => 'She ___ to school every day.', 'options' => ['A. go', 'B. goes', 'C. going'], 'answer' => 'goes', 'needs_check' => false],
                ['type' => 'pronunciation', 'prompt' => 'Choose the word with a different sound.', 'options' => ['b[oo]k', 'l[oo]k', 'f[oo]d'], 'answer' => 'f[oo]d', 'needs_check' => false],
                ['type' => 'reorder', 'prompt' => 'school / go / I / to', 'answer' => 'I go to school', 'needs_check' => false],
                // The model's answer is not among its options: kept, but marked for the teacher.
                ['type' => 'multiple_choice', 'prompt' => 'He ___ a doctor.', 'options' => ['is', 'are'], 'answer' => 'am', 'needs_check' => false],
                // An underlined-part question whose options lost their [marks].
                ['type' => 'pronunciation', 'prompt' => 'Choose the word whose underlined part is pronounced differently.', 'options' => ['hat', 'cake', 'map'], 'answer' => 'cake', 'needs_check' => false],
                ['type' => 'crossword', 'prompt' => 'Fill in the crossword'],
            ],
            'skipped' => ['Part D: listen to the recording (no script)'],
            'looks_like_textbook' => false,
        ];
    }

    private function upload(User $teacher, array $files, bool $confirm = true)
    {
        return Livewire::actingAs($teacher)
            ->test(CreateExercise::class)
            ->set('grade', 7)
            ->set('skill', 'language')
            ->set('method', 'upload')
            ->set('files', $files)
            ->set('confirmOwn', $confirm)
            ->set('confirmNoStudents', $confirm);
    }

    public function test_a_photo_of_the_teachers_test_becomes_a_draft_they_own_with_doubtful_questions_marked(): void
    {
        $teacher = User::factory()->teacher()->create();
        $this->fakeReading($this->readTest());

        $this->upload($teacher, [UploadedFile::fake()->image('de-kiem-tra.jpg', 1200, 1600)])
            ->call('readUpload')
            ->assertHasNoErrors()
            ->assertRedirect();

        $exercise = SkillExercise::with('questions')->sole();
        $this->assertSame($teacher->id, $exercise->owner_id);
        $this->assertSame(ExerciseSource::Upload, $exercise->source);
        $this->assertSame('Kiểm tra Unit 3', $exercise->title_vi);
        $this->assertCount(5, $exercise->questions);

        [$choice, $sound, $reorder, $wrong, $unmarked] = $exercise->questions->all();
        $this->assertTrue($unmarked->needs_check);
        $this->assertSame(['go', 'goes', 'going'], $choice->options, 'the A./B./C. letters are stripped');
        $this->assertFalse($choice->needs_check);
        $this->assertSame(QuestionType::Pronunciation, $sound->type);
        $this->assertFalse($reorder->needs_check);
        $this->assertTrue($wrong->needs_check);

        $this->assertContains('Part D: listen to the recording (no script)', $exercise->source_files['skipped']);
        $this->assertContains('Fill in the crossword', $exercise->source_files['skipped'], 'an unknown type is reported, not dropped silently');
        Storage::disk('local')->assertExists($exercise->source_files['files'][0]);
    }

    public function test_only_the_image_is_sent_never_the_teachers_name(): void
    {
        $teacher = User::factory()->teacher()->create(['name' => 'Nguyễn Thị Hoa', 'username' => 'gv.nguyenthihoa']);
        $this->fakeReading($this->readTest());

        $this->upload($teacher, [UploadedFile::fake()->image('de.png')])->call('readUpload');

        Http::assertSent(function (Request $request) {
            $body = json_encode($request->data(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            return str_contains($body, 'data:image/jpeg;base64,')
                && str_contains($body, 'never invent')
                && str_contains($body, 'the complete correct sentence, including any beginning the test gives')
                && ! str_contains($body, 'Nguyễn Thị Hoa')
                && ! str_contains($body, 'gv.nguyenthihoa')
                && ! str_contains($body, 'de.png');
        });
    }

    public function test_the_photo_is_re_encoded_without_its_metadata_and_shrunk(): void
    {
        $this->fakeReading($this->readTest());

        // A JPEG carrying an EXIF block (where phones keep GPS position and camera details).
        $image = imagecreatetruecolor(3000, 1500);
        ob_start();
        imagejpeg($image);
        $jpeg = ob_get_clean();
        $exif = "Exif\0\0".str_repeat('GPS-SECRET', 10);
        $withExif = substr($jpeg, 0, 2)."\xFF\xE1".pack('n', strlen($exif) + 2).$exif.substr($jpeg, 2);
        $file = UploadedFile::fake()->createWithContent('photo.jpg', $withExif);

        $this->upload(User::factory()->teacher()->create(), [$file])->call('readUpload');

        $stored = Storage::disk('local')->get(SkillExercise::sole()->source_files['files'][0]);
        $this->assertStringNotContainsString('GPS-SECRET', $stored);
        [$width, $height] = getimagesizefromstring($stored);
        $this->assertSame([2000, 1000], [$width, $height]);
    }

    public function test_both_confirmations_are_required_and_nothing_is_sent_without_them(): void
    {
        Http::fake();

        $this->upload(User::factory()->teacher()->create(), [UploadedFile::fake()->image('de.jpg')], confirm: false)
            ->call('readUpload')
            ->assertHasErrors(['confirmOwn', 'confirmNoStudents']);

        Http::assertNothingSent();
        $this->assertDatabaseCount('skill_exercises', 0);
    }

    public function test_photos_and_a_pdf_cannot_be_mixed(): void
    {
        Http::fake();

        $this->upload(User::factory()->teacher()->create(), [
            UploadedFile::fake()->image('page1.jpg'),
            UploadedFile::fake()->create('de.pdf', 100, 'application/pdf'),
        ])->call('readUpload')->assertHasErrors('files');

        Http::assertNothingSent();
    }

    public function test_other_file_types_are_refused(): void
    {
        Http::fake();

        $this->upload(User::factory()->teacher()->create(), [UploadedFile::fake()->create('de.docx', 50)])
            ->call('readUpload')
            ->assertHasErrors('files.0');

        Http::assertNothingSent();
    }

    public function test_a_pdf_is_sent_as_a_file(): void
    {
        $this->fakeReading($this->readTest());

        $this->upload(User::factory()->teacher()->create(), [UploadedFile::fake()->createWithContent('de.pdf', "%PDF-1.4\n%fake test\n")])
            ->call('readUpload')
            ->assertHasNoErrors();

        Http::assertSent(fn (Request $request) => str_contains(json_encode($request->data()), 'data:application\/pdf;base64,'));
    }

    public function test_an_ai_failure_stores_nothing_and_keeps_no_file(): void
    {
        Http::fake(['openrouter.ai/*' => Http::response([], 503)]);

        $this->upload(User::factory()->teacher()->create(), [UploadedFile::fake()->image('de.jpg')])
            ->call('readUpload')
            ->assertSee(__('skills.upload_failed'));

        $this->assertDatabaseCount('skill_exercises', 0);
        $this->assertSame([], Storage::disk('local')->allFiles('exercise-sources'));
    }

    public function test_a_test_with_no_readable_question_says_so(): void
    {
        $this->fakeReading([...$this->readTest(), 'questions' => []]);

        $this->upload(User::factory()->teacher()->create(), [UploadedFile::fake()->image('de.jpg')])
            ->call('readUpload')
            ->assertSee(__('skills.upload_empty'));

        $this->assertDatabaseCount('skill_exercises', 0);
    }

    public function test_a_page_that_looks_like_the_textbook_is_flagged_in_the_editor(): void
    {
        $teacher = User::factory()->teacher()->create();
        $this->fakeReading([...$this->readTest(), 'looks_like_textbook' => true]);

        $this->upload($teacher, [UploadedFile::fake()->image('de.jpg')])->call('readUpload');

        $this->actingAs($teacher)
            ->get(route('exercises.edit', SkillExercise::sole()))
            ->assertOk()
            ->assertSee(__('skills.looks_like_textbook'))
            ->assertSee(__('skills.original'));
    }

    public function test_only_the_owner_can_open_the_original_file(): void
    {
        $teacher = User::factory()->teacher()->create();
        $this->fakeReading($this->readTest());
        $this->upload($teacher, [UploadedFile::fake()->image('de.jpg')])->call('readUpload');
        $exercise = SkillExercise::sole();

        $this->actingAs($teacher)->get(route('exercises.source', [$exercise, 0]))->assertOk()->assertHeader('Content-Type', 'image/jpeg');
        $this->actingAs($teacher)->get(route('exercises.source', [$exercise, 5]))->assertNotFound();
        $this->actingAs(User::factory()->teacher()->create())->get(route('exercises.source', [$exercise, 0]))->assertForbidden();
        $this->actingAs(User::factory()->student()->create())->get(route('exercises.source', [$exercise, 0]))->assertForbidden();
    }
}
