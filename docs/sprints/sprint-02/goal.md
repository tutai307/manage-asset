# Sprint 2 — 2026-09-21 -> 2026-09-27

**Status:** Active — the customer approved the feature order 1 -> 2 -> 11 -> 9 on 2026-09-20.

## Goal

A student can speak instead of typing, ask for a hint when stuck, and get the AI to mark the
sentences they produced.

## Committed

| ID | Title | SP | Status |
| --- | --- | --- | --- |
| AM-006 | Speak in the role-play instead of typing | 5 | Built |
| AM-007 | Feedback on the sentences after a role-play | 5 | Built |
| AM-008 | Ask for a hint during the role-play | 2 | Built |
| | **Total** | **12** | |

AM-T02 (speech spike) is closed: the question was answered by building AM-006.

## Next, after the customer has seen these

AM-013 (pre/post test for the trial) and AM-012 (teacher statistics) — items 11 and 9 of the
proposal list, in that order.

## Verification

- `php artisan test`: 78 passed (246 assertions)
- `vendor/bin/pint --dirty`: clean
- `npm run build`: OK
- Migration `2026_09_21_000001_create_roleplay_reviews_tables` applied to MySQL
- **Not verified:** speech recognition (browser API, needs a real Chrome/Edge session) and every
  live AI call — still no OpenRouter key in `.env`.

## Live AI verification — 2026-09-21

The customer added `OPENROUTER_API_KEY`, so AM-T01 is closed and the AI paths were run for real:

- `php artisan ai:compare-models`: 3 models, 0 failures, 0.95-1.87s average. Model chosen:
  `anthropic/claude-haiku-4.5` — see ADR-0003.
- End-to-end role-play + hint + feedback against the live API: replies 1.3-2.5s, feedback 4.2-4.9s.
- **Bug found and fixed by running it:** the hint was built from the opening line instead of the
  latest partner line, because the `messages()` relation is ordered ascending and `latest()` was
  ignored. Fixed with `reorder()`, plus the last four turns are now sent as context. A test now
  asserts the newest partner line wins.
- Role-play prompt now states the setting is Vietnam, so prices come back in dong rather than dollars.

Still unverified: speech recognition in a real browser.
