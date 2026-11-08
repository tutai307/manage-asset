<?php

namespace App\Livewire\Skills;

use App\Actions\Skills\CreateBlankExercise;
use App\Actions\Skills\ReadExerciseFromUpload;
use App\Enums\SkillType;
use App\Exceptions\AiUnavailableException;
use App\Exceptions\NothingToReadException;
use App\Models\CurriculumUnit;
use App\Models\SkillExercise;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateExercise extends Component
{
    use WithFileUploads;

    public const MAX_FILES = 5;

    public const MAX_FILE_KB = 10240;

    public string $method = 'upload';

    public ?int $grade = null;

    #[Url(as: 'unit')]
    public ?int $unitId = null;

    public string $skill = 'language';

    /** @var list<UploadedFile> */
    public array $files = [];

    public bool $confirmOwn = false;

    public bool $confirmNoStudents = false;

    public ?string $error = null;

    public function mount(): void
    {
        Gate::authorize('create', SkillExercise::class);

        $unit = $this->unitId ? CurriculumUnit::find($this->unitId) : null;
        $this->unitId = $unit?->id;
        $this->grade = $unit?->grade ?? 6;
    }

    public function updatedGrade(): void
    {
        // A unit belongs to one grade; changing grade clears a unit of another grade.
        if ($this->unitId && CurriculumUnit::whereKey($this->unitId)->value('grade') !== $this->grade) {
            $this->unitId = null;
        }
    }

    public function createBlank(CreateBlankExercise $createBlankExercise): void
    {
        Gate::authorize('create', SkillExercise::class);

        $this->validate($this->targetRules(array_column(SkillType::cases(), 'value')));

        $exercise = $createBlankExercise->handle(auth()->user(), SkillType::from($this->skill), $this->unit(), $this->grade);

        $this->redirectRoute('exercises.edit', $exercise, navigate: false);
    }

    /**
     * AM-029: read a photographed or PDF test into a draft the teacher then checks.
     */
    public function readUpload(ReadExerciseFromUpload $readExerciseFromUpload): void
    {
        Gate::authorize('create', SkillExercise::class);

        $this->error = null;

        $this->validate([
            ...$this->targetRules(array_map(fn (SkillType $s) => $s->value, ReadExerciseFromUpload::SKILLS)),
            'files' => ['required', 'array', 'min:1', 'max:'.self::MAX_FILES],
            'files.*' => ['file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:'.self::MAX_FILE_KB],
            'confirmOwn' => ['accepted'],
            'confirmNoStudents' => ['accepted'],
        ], attributes: [
            'files' => __('skills.files'),
            'files.*' => __('skills.files'),
            'confirmOwn' => __('skills.confirm_own'),
            'confirmNoStudents' => __('skills.confirm_no_students'),
        ]);

        $pdfs = collect($this->files)->filter(fn (UploadedFile $file) => $file->getMimeType() === 'application/pdf')->count();

        if ($pdfs > 0 && count($this->files) > 1) {
            $this->addError('files', __('skills.files_mixed'));

            return;
        }

        try {
            $exercise = $readExerciseFromUpload->handle(auth()->user(), array_values($this->files), SkillType::from($this->skill), $this->unit(), $this->grade);
        } catch (NothingToReadException) {
            $this->error = __('skills.upload_empty');

            return;
        } catch (AiUnavailableException) {
            $this->error = __('skills.upload_failed');

            return;
        }

        session()->flash('status', __('skills.upload_read', ['count' => $exercise->questions->count()]));

        $this->redirectRoute('exercises.edit', $exercise, navigate: false);
    }

    public function removeFile(int $index): void
    {
        unset($this->files[$index]);
        $this->files = array_values($this->files);
    }

    public function render()
    {
        return view('livewire.skills.create-exercise', [
            'grades' => [6, 7, 8, 9],
            'units' => CurriculumUnit::query()->where('grade', $this->grade)->orderBy('number')->get(['id', 'grade', 'number', 'title_en', 'title_vi']),
            'skills' => array_values(array_filter(SkillType::cases(), fn (SkillType $s) => $s !== SkillType::Speaking)),
            'uploadSkills' => ReadExerciseFromUpload::SKILLS,
        ])->title(__('skills.create_title'));
    }

    /**
     * @param  list<string>  $skills
     */
    private function targetRules(array $skills): array
    {
        return [
            'grade' => ['required', 'integer', 'between:6,9'],
            'unitId' => ['nullable', 'integer', Rule::exists('curriculum_units', 'id')->where('grade', $this->grade)],
            'skill' => ['required', Rule::in($skills)],
        ];
    }

    private function unit(): ?CurriculumUnit
    {
        return $this->unitId ? CurriculumUnit::find($this->unitId) : null;
    }
}
