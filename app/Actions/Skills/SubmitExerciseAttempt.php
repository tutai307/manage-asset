<?php

namespace App\Actions\Skills;

use App\Enums\SkillType;
use App\Exceptions\AiUnavailableException;
use App\Models\ExerciseAttempt;
use App\Models\SkillExercise;
use App\Models\User;
use App\Services\Ai\OpenRouterClient;
use Illuminate\Support\Facades\Log;

class SubmitExerciseAttempt
{
    public function __construct(private readonly OpenRouterClient $ai) {}

    /**
     * Mark a set of answers. Questions are marked locally; a piece of writing is marked by the AI.
     *
     * @param  array<int, string>  $answers  question id => answer given
     *
     * @throws AiUnavailableException when a writing task cannot be marked
     */
    public function handle(User $student, SkillExercise $exercise, array $answers, ?string $writtenAnswer = null): ExerciseAttempt
    {
        $exercise->loadMissing('questions');

        if ($exercise->skill === SkillType::Writing) {
            return $this->markWriting($student, $exercise, (string) $writtenAnswer);
        }

        $marked = [];
        $score = 0;

        foreach ($exercise->questions as $question) {
            $given = $answers[$question->id] ?? null;
            $correct = $question->isCorrect($given);
            $score += $correct ? 1 : 0;

            $marked[$question->id] = ['given' => $given, 'correct' => $correct];
        }

        return ExerciseAttempt::create([
            'user_id' => $student->id,
            'skill_exercise_id' => $exercise->id,
            'score' => $score,
            'max_score' => $exercise->questions->count(),
            'answers' => $marked,
        ]);
    }

    /**
     * @throws AiUnavailableException
     */
    private function markWriting(User $student, SkillExercise $exercise, string $text): ExerciseAttempt
    {
        $words = str_word_count(strip_tags($text));

        $answer = $this->ai->chat([
            ['role' => 'system', 'content' => <<<'PROMPT'
            You mark a short piece of writing by a Vietnamese lower-secondary student. Be encouraging and concrete.

            Reply with JSON only, no markdown fence:
            {"score": <0-10>, "feedback_vi": "<3-4 short Vietnamese sentences: what is good, the two main mistakes with the corrected form, one thing to do next time>",
             "feedback_en": "<the same in simple English>"}

            Judge the task, not the handwriting: content first, then grammar and spelling.
            Never mention the student's name.
            PROMPT],
            ['role' => 'user', 'content' => "Task: {$exercise->prompt_en}\nMinimum length: {$exercise->min_words} words. The student wrote {$words} words.\n\nStudent's writing:\n{$text}"],
        ], maxTokens: 600, temperature: 0.2);

        $json = trim(preg_replace('/^```(?:json)?|```$/m', '', $answer));
        $payload = json_decode($json, true);

        if (! is_array($payload) || ! filled($payload['feedback_vi'] ?? null)) {
            Log::warning('Writing feedback could not be parsed', ['answer' => mb_substr($answer, 0, 400)]);

            throw new AiUnavailableException('The writing could not be marked.');
        }

        return ExerciseAttempt::create([
            'user_id' => $student->id,
            'skill_exercise_id' => $exercise->id,
            'score' => max(0, min(10, (int) ($payload['score'] ?? 0))),
            'max_score' => 10,
            'answers' => [],
            'written_answer' => $text,
            'feedback_vi' => trim($payload['feedback_vi']),
            'feedback_en' => trim((string) ($payload['feedback_en'] ?? $payload['feedback_vi'])),
        ]);
    }
}
