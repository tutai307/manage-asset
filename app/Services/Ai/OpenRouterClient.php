<?php

namespace App\Services\Ai;

use App\Exceptions\AiUnavailableException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Support\Facades\Log;

/**
 * Thin client for the OpenRouter chat completions API (OpenAI-compatible).
 */
class OpenRouterClient
{
    public function __construct(private readonly HttpFactory $http) {}

    public function isConfigured(): bool
    {
        return filled(config('services.openrouter.key'));
    }

    /**
     * A message's content is a string, or a list of parts (text, image_url, file) for a vision model.
     * The timeout is in seconds; reading an uploaded test takes far longer than a chat reply.
     *
     * @param  list<array{role: string, content: string|list<array<string, mixed>>}>  $messages
     */
    public function chat(array $messages, ?string $model = null, int $maxTokens = 300, float $temperature = 0.7, ?int $timeout = null): string
    {
        if (! $this->isConfigured()) {
            throw new AiUnavailableException('OpenRouter API key is not configured.');
        }

        $model ??= config('services.openrouter.model');

        try {
            $response = $this->http
                ->baseUrl(config('services.openrouter.base_url'))
                ->withToken(config('services.openrouter.key'))
                ->withHeaders(['X-Title' => config('app.name')])
                ->timeout($timeout ?? (int) config('services.openrouter.timeout'))
                ->acceptJson()
                ->post('/chat/completions', [
                    'model' => $model,
                    'messages' => $messages,
                    'max_tokens' => $maxTokens,
                    'temperature' => $temperature,
                ]);
        } catch (ConnectionException $e) {
            Log::warning('OpenRouter connection failed', ['model' => $model, 'error' => $e->getMessage()]);

            throw new AiUnavailableException('OpenRouter connection failed.', previous: $e);
        }

        if ($response->failed()) {
            Log::warning('OpenRouter request failed', ['model' => $model, 'status' => $response->status()]);

            throw new AiUnavailableException("OpenRouter returned HTTP {$response->status()}.");
        }

        $content = trim((string) $response->json('choices.0.message.content'));

        if ($content === '') {
            Log::warning('OpenRouter returned an empty reply', ['model' => $model]);

            throw new AiUnavailableException('OpenRouter returned an empty reply.');
        }

        return $content;
    }
}
