---
name: db-schema
description: Database and migration conventions for this project — column types, naming, indexes and foreign keys, append-only tables, soft deletes, dates, bilingual columns, migration safety. Load before writing any migration or designing any table.
---

# Schema & migrations — English Buddy

Application database: **MySQL 8**, `utf8mb4_unicode_ci` ([ADR-0004](../../../docs/architecture/adr/0004-mysql-database.md)).
Test database: **in-memory SQLite** (`phpunit.xml`). Every migration must run on both, so no
vendor-specific column types or `DB::statement` without an ADR.

Read the existing migrations in `database/migrations/` before adding one — they are the reference
for the patterns below.

---

## Migration rules

- One migration per logical change. Never edit a migration that has been merged — fix it forward
  with a new one.
- `down()` must genuinely reverse `up()`. If it cannot (data loss), say so in a comment and make
  `down()` throw rather than silently doing something different.
- Never `migrate:fresh` against anything that could contain real teacher or student records. Not in
  a script, not in a suggestion to the customer.
- Content does not belong in a migration. Use an idempotent seeder that never overwrites a teacher's
  edits (see `UnitFocusSeeder`, `UnitExerciseSeeder`).

## Column types

| Data | Type | Notes |
| --- | --- | --- |
| Names, Vietnamese text | `string(n)` with a deliberate length | `utf8mb4` keeps diacritics exact. |
| Bilingual content | paired `*_en` / `*_vi` columns | e.g. `title_en` / `title_vi`. Learning content is always stored in both languages. |
| Long text | `text` | Passages, writing answers, AI feedback. |
| Status, role, skill, question type | `string(20–30)` + PHP backed enum cast | Not a DB `enum` — altering those is painful. Index it if lists filter on it. |
| Small counts and ordering | `unsignedSmallInteger` / `unsignedTinyInteger` | `sort_order`, `grade`, `term`, `score`. |
| Structured answers or options | `json` | Only for data that is read and written as a whole (`options`, `answers`). Never query inside it. |
| Event timestamp | `timestamp` | Stored UTC; shown in `config('app.display_timezone')`. |
| Foreign key | `foreignId(...)->constrained()` | Always indexed, always an explicit `onDelete`. |

## Foreign key behaviour — decide, do not default

| Relationship kind | Behaviour | Example |
| --- | --- | --- |
| Child content owned by its parent | `cascadeOnDelete()` | `exercise_questions.skill_exercise_id` |
| Student work belonging to a student | `cascadeOnDelete()` | `exercise_attempts.user_id` — users are soft-deleted, so this rarely fires |
| A record other people depend on | `restrictOnDelete()` | `classrooms.teacher_id`, `conversations.roleplay_scenario_id` |
| An optional link | `nullOnDelete()` | `topics.curriculum_unit_id` |

## Indexes

Index, at minimum:
- every foreign key column
- what lists filter and sort on, as composites in the real query shape, equality filters first:
  `['curriculum_unit_id', 'skill', 'status']`, `['topic_id', 'sort_order']`
- natural uniqueness as a constraint, not an application check: `['grade', 'number']` on units,
  `['curriculum_unit_id', 'word']` on vocabulary, `['classroom_id', 'user_id']` on membership

Do not index everything — every index slows writes.

## Append-only tables

Student work and AI output are evidence for the trial: `conversation_messages`, `roleplay_reviews`,
`exercise_attempts`, `pattern_reveals`.

- One row per event; never updated or deleted. A retry is a new row.
- Use `timestamp('created_at')->useCurrent()` without `updated_at`, and mark the model
  *Append-only* in its docblock with `const UPDATED_AT = null`.
- Index for the reads that matter: `['user_id', 'created_at']`, `['skill_exercise_id', 'created_at']`.

## Soft deletes

- `softDeletes()` on `users` and `classrooms` — removing a student must not destroy their work.
- Content tables may be hard-deleted with their children (cascade) — they are not personal data.
- Append-only tables are never deleted, soft or hard.
- `unique` still collides with soft-deleted rows (e.g. `users.username`). Decide whether a retired
  username may be reused — do not discover it in production.

## Personal data

Store the minimum: name, username, role, class. No email, birth date, phone or address for students
unless the customer confirms the need. Nothing in the schema is ever sent to the AI provider except
learning content and the conversation text.

## Before you hand over a migration

- Does `php artisan migrate` then `php artisan migrate:rollback` work cleanly on MySQL, and does the
  test suite pass on SQLite?
- Is there a factory for the new model, producing valid data?
- Does the change need a backfill for existing rows? Write it as a separate, idempotent, re-runnable
  command — not inside the migration.
