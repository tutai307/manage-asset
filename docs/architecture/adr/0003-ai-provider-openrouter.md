# ADR-0003 — AI through OpenRouter, model chosen by measurement

- **Status:** Accepted
- **Date:** 2026-09-21 (proposed 2026-09-18)
- **Deciders:** delivery lead, customer

## Context

The product (see [vision.md](../../product/vision.md)) needs an AI partner for English role-play
with THCS students, feedback on what they wrote, and hints when they are stuck. Constraints:

- The customer supplies an **OpenRouter** API key and pays for usage (discovery Session 6).
- Replies must be A1–A2 level, stay in role, refuse unsafe content, and appear in under 5 seconds.
- Users are minors: no personal data may be sent to the provider.
- The competition demo depends on the AI working reliably at a booth.

## Decision

1. All AI calls go through one thin client, `App\Services\Ai\OpenRouterClient`, speaking the
   OpenAI-compatible chat completions API at `https://openrouter.ai/api/v1`.
2. Key, base URL, model and timeout are read from `config/services.php` → `.env`
   (`OPENROUTER_API_KEY`, `OPENROUTER_MODEL`, `OPENROUTER_TIMEOUT`). The key is never logged.
3. **Model: `anthropic/claude-haiku-4.5`**, on the evidence below. `google/gemini-2.5-flash` is the
   fallback if latency ever becomes a problem at the booth — switching is an `.env` change.
4. Any provider failure becomes `AiUnavailableException`; the UI shows a friendly retry message and
   nothing is stored.
5. Only scenario/topic text and the conversation itself are sent — never names or usernames.
   Covered by tests in `RoleplayConversationTest`, `RoleplayReviewTest` and `RoleplayHintTest`.

## Evidence (AM-T01, measured 2026-09-21)

`php artisan ai:compare-models`, 5 fixed THCS prompts per model, from the development machine:

| Model | Avg | Max | Failures | Judgement |
| --- | --- | --- | --- | --- |
| `anthropic/claude-haiku-4.5` | 1.65s | 1.75s | 0 | **Chosen.** Stays in role, asks a follow-up question every time so the conversation keeps going, refuses the bad-word request warmly and redirects. Most consistent latency. |
| `openai/gpt-4o-mini` | 1.87s | 2.93s | 0 | Good replies, but the most variable latency (2.9s worst case). |
| `google/gemini-2.5-flash` | 0.95s | 1.08s | 0 | Fastest, but terse: short replies give the learner less to respond to. Good fallback. |

End-to-end check on the real API (role-play, hint, feedback), same day: replies 1.3–2.5s, feedback
4.2–4.9s, and the feedback correctly marked "I take it. Here you are." → "I'll take it. Here you
are." with a Vietnamese explanation.

## Options considered

**A. OpenRouter with a configurable model (chosen).** The customer already has a key. One API gives
access to several providers, so the model can be switched in `.env` if one is slow or poor at the
booth. Cost: an extra intermediary, and model IDs are OpenRouter-specific.

**B. A single provider's SDK directly.** Slightly less latency, but requires a separate key the
customer does not have, and locks the model choice into code.

## Consequences

- Switching model is an `.env` change plus a re-run of the comparison command.
- Tests never call the real API (`Http::fake`); `phpunit.xml` sets a dummy key.
- The app needs internet access wherever it is demoed. Feedback takes ~5s, so the UI must show a
  working state while it runs.
