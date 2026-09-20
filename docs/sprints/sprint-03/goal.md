# Sprint 3 — 2026-09-23 -> 2026-09-29

**Status:** Active.

## Goal

Every unit can be practised in all four skills, with content tied to the vocabulary and grammar the
class is actually learning.

## Committed

| ID | Title | SP | Status |
| --- | --- | --- | --- |
| AM-022 | Unit vocabulary and grammar, entered or approved by the teacher | 5 | Built |
| AM-018 | Reading practice per unit | 8 | Built |
| AM-019 | Listening practice per unit | 8 | Built |
| AM-020 | Writing practice per unit, marked by AI | 8 | Built |
| | **Total** | **29** | |

Speaking needs no new story: it is the role-play from AM-005/006/007, linked from each unit.

## Why AM-022 came first

The customer objected, correctly, that "AI generates the content" is not the same as "follows the
book". The fix is not to copy the book (ADR-0005) but to pin down what the unit teaches: the
teacher types or approves the unit word list and grammar point, and every generated exercise is
restricted to it. Generation is refused while that list is empty.

## Verification

- `php artisan test`: 113 passed (345 assertions)
- `vendor/bin/pint --dirty`: clean; `npm run build`: OK
- Live run on grade 8 unit 8 (Shopping): vocabulary suggested in 4.9s (16 words), reading built in
  6.7s with 5 questions, listening in 6.1s with 4 questions, writing task in 8.9s. Generated text
  used the saved words (cost, discount, fit, receipt, cash) and dong prices.

## Not verified

- Speech recognition in a real browser (AM-006), still needs a Chrome session.
- Nothing in the UI has been looked at in a browser this sprint.

## Shipped content — 2026-09-23

AM-023: the product no longer asks each teacher to generate 48 units.

- `php artisan curriculum:build-focus-seed` drafted vocabulary and grammar for all 48 units; the
  result is committed as `database/seeders/data/unit_focus.php` (786 words).
- `php artisan curriculum:build-exercise-seed` drafted reading, listening and writing practice for
  all 48 units; committed as `database/seeders/data/unit_exercises.php` (144 exercises, 432
  questions).
- `UnitFocusSeeder` and `UnitExerciseSeeder` load them. Both are idempotent and **never overwrite a
  teachers edit**: a unit whose focus is approved, or that already has an exercise for a skill,
  is skipped.
- Teachers edit any exercise at `/exercises/{id}/edit`: title, instructions, passage or script,
  writing task, and each question (type, options, answer, explanation), adding or removing
  questions. An answer that is not among its options is refused.

A fresh install now has content for every grade with zero AI calls. Generation stays available for
teachers who want an extra exercise.

`php artisan test`: 129 passed (1300 assertions).
