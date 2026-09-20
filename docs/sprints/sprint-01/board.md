# Sprint 1 board

Last updated: 2026-09-18. All work is uncommitted on branch `feature/AM-001-sign-in` — the customer
has not yet asked for commits, so per-story branches could not be separated.

| ID | Title | Status | Notes |
| --- | --- | --- | --- |
| AM-T01 | Spike: OpenRouter integration | **Blocked** | Client, config, tests and `php artisan ai:compare-models` built. ADR-0003 Proposed. Waiting for `OPENROUTER_API_KEY` in `.env` to measure models. |
| AM-001 | Sign in as teacher or student | Built, awaiting review | Username sign-in, throttling, role redirect. |
| AM-002 | Class and student accounts | Built, awaiting review | Also: password reset per student (needed because passwords are shown once). |
| AM-003 | Starter topics | Built, awaiting teacher review of content | 12 topics, 99 patterns, 24 scenarios. |
| AM-004 | Learn sentences | Built, awaiting review | 3 support levels: Đầy đủ / Gợi ý / Chỉ tiếng Anh. Browser text-to-speech. |
| AM-005 | Text role-play with AI | Built, not verified against the real AI | Verified with faked HTTP only until the key is provided. |
| AM-014 | VI / EN interface switch | Built, awaiting review | Added mid-sprint at the customer's request (+3 SP). Saved per account; English descriptions for all 12 topics and 24 scenarios. |

## Verification

- `php artisan test`: 53 passed (182 assertions)
- `vendor/bin/pint --dirty`: clean
- `npm run build`: OK
- Migrations: migrate → rollback → migrate clean on dev SQLite, and again on **MySQL 8.0.42**
  (`english_buddy`, utf8mb4_unicode_ci — ADR-0004); demo seed OK, Vietnamese text round-trips exactly
- Real browser run: **not done** — only the login page was fetched over HTTP (200)

## Impediments

1. OpenRouter key not yet in `.env` — blocks AM-T01 and a real AM-005 check.
2. ~~`.env` has `APP_LOCALE=en`~~ — resolved by AM-014: users switch language with the VI/EN button.

## Scope added mid-sprint

| ID | Title | SP | Status |
| --- | --- | --- | --- |
| AM-014 | VI / EN interface switch | 3 | Built |
| AM-015 | Dashboard, sidebar navigation, conversation history | 5 | Built |

Sprint total is now 30 SP against unknown capacity. Verification after AM-015:
`php artisan test` 65 passed (211 assertions), Pint clean, `npm run build` OK.
The redesign has **not** been checked in a real browser yet.
