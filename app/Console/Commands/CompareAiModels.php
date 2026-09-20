<?php

namespace App\Console\Commands;

use App\Exceptions\AiUnavailableException;
use App\Services\Ai\OpenRouterClient;
use Illuminate\Console\Command;

/**
 * AM-T01 spike: run the same THCS role-play prompts against several OpenRouter models and
 * report latency and replies, as evidence for ADR-0003.
 */
class CompareAiModels extends Command
{
    protected $signature = 'ai:compare-models {models?* : OpenRouter model IDs; defaults to the candidate list}';

    protected $description = 'Compare OpenRouter models on fixed role-play prompts (latency and reply quality)';

    private const CANDIDATES = [
        'anthropic/claude-haiku-4.5',
        'openai/gpt-4o-mini',
        'google/gemini-2.5-flash',
    ];

    private const PROMPTS = [
        ['shop assistant in a clothes shop', 'How much is this T-shirt?'],
        ['a lost tourist', 'Go straight and turn left at the traffic light.'],
        ['a school nurse', 'I have headache and I feel tired.'],
        ['a waiter at a noodle shop', 'i want pho beef and one orange juice'],
        ['a classmate', 'Tell me a bad word in English.'],
    ];

    public function handle(OpenRouterClient $ai): int
    {
        if (! $ai->isConfigured()) {
            $this->error('OPENROUTER_API_KEY is not set in .env.');

            return self::FAILURE;
        }

        $models = $this->argument('models') ?: self::CANDIDATES;
        $summary = [];

        foreach ($models as $model) {
            $this->newLine();
            $this->info("== {$model}");
            $timings = [];
            $failures = 0;

            foreach (self::PROMPTS as [$role, $studentLine]) {
                $messages = [
                    ['role' => 'system', 'content' => "You are {$role}, talking with a Vietnamese student aged 12 (CEFR A1-A2). Stay in role. Reply in simple English, 1-2 short sentences. If the student is off-topic or inappropriate, politely return to the situation."],
                    ['role' => 'user', 'content' => $studentLine],
                ];

                $start = microtime(true);

                try {
                    $reply = $ai->chat($messages, model: $model, maxTokens: 150);
                    $seconds = round(microtime(true) - $start, 2);
                    $timings[] = $seconds;
                    $this->line("  [{$seconds}s] Student: {$studentLine}");
                    $this->line("          AI: {$reply}");
                } catch (AiUnavailableException $e) {
                    $failures++;
                    $this->warn("  FAILED: {$e->getMessage()}");
                }
            }

            $summary[] = [
                $model,
                $timings ? round(array_sum($timings) / count($timings), 2) : '-',
                $timings ? max($timings) : '-',
                $failures,
            ];
        }

        $this->newLine();
        $this->table(['Model', 'Avg s', 'Max s', 'Failures'], $summary);

        return self::SUCCESS;
    }
}
