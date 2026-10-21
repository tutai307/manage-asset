---
name: testing-strategy
description: How this project tests — PHPUnit 11 layout, what to test at which level, factories and seeders, Livewire component testing, authorization testing, faking the AI, and the Vietnamese data cases that must be covered. Load before writing tests or judging whether a story has enough coverage.
---

# Testing — English Buddy

PHPUnit 11 · Laravel 12 · SQLite in-memory for the suite (`phpunit.xml`) · `php artisan test`.

---

## Shape of the suite

`tests/Feature/<Feature>/` mirrors `app/Actions/<Feature>/` and `app/Livewire/<Feature>/`
(Auth, Classrooms, Curriculum, Roleplay, Skills, Topics). `tests/Unit/` holds pure logic only —
parsing and calculations with no database (`UnitFocusParsingTest`, `CalculateLearningStreakTest`).

Most tests here are **Feature** tests. A unit test with the database mocked out proves almost
nothing about a Livewire + Eloquent application.

## What must be covered, in priority order

1. **Authorization, both directions.** For every protected operation: an authorised user succeeds
   *and* an unauthorised one is blocked — another teacher's class, another student's conversation
   or attempt, a student trying a teacher action. Manual testing is done as admin and never catches
   these.
2. **Visibility.** Students see only their own grade's units and only **published** content; a
   draft is a 404 for them. Test the list query, not just the detail page.
3. **The AI boundary.** With `Http::fake`: what is sent (never a name or username — see
   `RoleplayConversationTest::test_request_to_ai_contains_role_and_history_but_not_the_students_name`),
   what happens on a provider failure or missing key (friendly message, nothing stored), and that
   malformed AI output is dropped rather than stored.
4. **Teacher control.** Generation is refused while the unit vocabulary is empty; re-running a
   seeder never overwrites an approved focus or an edited exercise.
5. **Append-only records.** Every attempt is kept; retries add rows.
6. **Validation boundaries.** Blank answers, an answer missing from its options, a vocabulary line
   that cannot be parsed, writing under the minimum length — each refused before the AI is called.
7. **Vietnamese text.** Names and meanings with diacritics ("Nguyễn Thị Ánh", "cửa hàng") round-trip
   exactly through create → store → display.
8. **Happy path.** Yes, last.

## Rules

- `use RefreshDatabase;` on every database test. Never `migrate:fresh` inside a test.
- **Never call the real AI.** Every test that reaches an Action using `OpenRouterClient` fakes HTTP.
- Test names state behaviour: `test_students_cannot_open_a_draft_exercise()`.
- One behaviour per test, Arrange / Act / Assert visibly separated by blank lines.
- **Assert on values you set.** A test that asserts on `fake()` output is flaky by construction.
- Assert the **database**, not just the response: `assertDatabaseHas`, `assertDatabaseCount`,
  `assertSoftDeleted`.
- Would the test still pass if the feature were deleted? If yes, it is not a test. Asserting only
  `assertStatus(200)` is the usual offender.
- No sleeps, no order dependence, no shared state between tests.

## Factories

Every model gets a factory with named states for the interesting cases, e.g.
`User::factory()->teacher()`, `SkillExercise::factory()->draft()->writing()`,
`CurriculumUnit::factory()->grade(8)`. Read `database/factories/` before adding a state.

Factories generate *valid* data by default. If a factory can produce a record that violates a
business rule, the factory is wrong and it will hide real bugs.

## Authorization and AI test patterns

Use the existing tests as the reference rather than a template here:
- Blocked access: `SkillExerciseTest::test_students_cannot_open_a_draft_exercise`,
  `RoleplayConversationTest::test_student_cannot_open_another_students_conversation`
- AI failure: `RoleplayConversationTest::test_ai_failure_shows_busy_message_keeps_the_text_and_stores_nothing`
- Refused before calling the AI: `SkillExerciseTest::test_generation_is_refused_until_the_teacher_has_entered_the_unit_vocabulary`

After a refusal, also assert that nothing was written — a 403 alone does not prove it.

## Livewire tests

- Test through the component API — `Livewire::actingAs($user)->test(Component::class, [...])`,
  then `set`, `call`, `assertSee`, `assertHasErrors`, `assertForbidden`. Never regex over the
  rendered HTML.
- Test the guard, not just the flow: call the action as a user without the permission.

## Seeders

- `DatabaseSeeder` is the demo dataset for sprint reviews: the syllabus, starter topics, shipped
  unit content, and one account per role with Vietnamese names. Never run against production.
- Content seeders are **idempotent and non-destructive** and have their own tests
  (`UnitFocusSeederTest`, `UnitExerciseSeederTest`, `StarterTopicSeederTest`).
- No real personal data in seeders, ever.

## Reporting results

Run `php artisan test` and report the real numbers — tests, assertions, failures, duration. If the
suite is red, show the failure output and say what you believe is wrong. Never call a red suite
"mostly passing", and never delete, skip or weaken a test to make it green.
