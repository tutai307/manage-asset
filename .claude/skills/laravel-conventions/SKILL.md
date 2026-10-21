---
name: laravel-conventions
description: Coding standards for this Laravel 12 / PHP 8.2 codebase — layering, naming, models, actions, policies, validation, enums, errors, localisation. Load before writing or reviewing any PHP in this project.
---

# Laravel conventions — English Buddy

Laravel 12 · PHP 8.2 · PHPUnit 11 · Pint (Laravel preset).

Where these rules and a Laravel tutorial disagree, these rules win. Where these rules and the
existing codebase disagree, read the code and raise the inconsistency.

---

## Layering

```
routes/web.php
     │
Livewire component  /  Controller       ← thin. Input, authorize, delegate, respond.
     │
app/Actions/*                           ← one business operation. Transactional. Testable alone.
     │
app/Models/*                            ← relationships, casts, scopes. No orchestration.
```

- A component/controller method should be readable in one screen.
- An `Action` has exactly one public entry point (`__invoke` or `handle`) and a constructor for
  dependencies. Name it as a verb phrase: `CreateStudentAccounts`, `SaveUnitFocus`, `ReviewRoleplay`.
- Use a `Service` only when several Actions share stateful coordination. Prefer Actions.
- Plain CRUD does not need an Action. Reserve them for operations with rules.

## Naming

| Thing | Convention | Example |
| --- | --- | --- |
| Model | singular PascalCase | `SkillExercise`, `CurriculumUnit` |
| Table | plural snake_case | `skill_exercises`, `curriculum_units` |
| Pivot table | singular models, alphabetical | `classroom_user` |
| FK column | `<singular>_id` | `curriculum_unit_id`, `teacher_id` |
| Boolean column | `is_` / `has_`, or a past participle for a state | `focus_approved` |
| Bilingual columns | `_en` / `_vi` suffix | `title_en`, `title_vi` |
| Action | verb + noun, grouped by feature folder | `Skills\SubmitExerciseAttempt` |
| Policy | `<Model>Policy` | `SkillExercisePolicy` |
| Enum | singular PascalCase | `SkillType`, `SupportLevel` |
| Test | `<Subject>Test` | `RoleplayHintTest` |
| Route name | `resource.action` | `curriculum.show`, `exercises.edit` |

Domain terms come from [docs/product/glossary.md](../../../docs/product/glossary.md). One concept,
one name, in code and in the UI.

## Models

Look at `app/Models/SkillExercise.php` as the reference shape.

- `$fillable`, always. `$guarded = []` is banned.
- `casts()` method, not the `$casts` property (Laravel 11+). Enums are cast.
- Relationships are typed: `public function unit(): BelongsTo`.
- Query scopes for repeated filters, especially visibility: `scopeVisibleTo(User $user)`,
  `scopePublished`, `scopeForGrade`.
- Models marked *Append-only* in their docblock are never updated or deleted.
- No HTTP, no request access, no view rendering, no AI calls in a model.
- Global scopes only when the rule is genuinely universal — a forgotten global scope is very hard to
  debug. Prefer an explicit scope call.

## Enums

Backed enums in `app/Enums/`, always. Never a bare status string. Pure rules live on the enum, so
the UI and the Action ask the same question and cannot disagree — see `SkillType::isMarkedByAi()`,
`TopicStatus::isVisibleToStudents()`, `UserRole::canTeach()`. Labels come from `lang/`:
`__("skills.type.{$this->value}")`.

## Authorization

- One Policy per model, methods matching the ability: `view`, `create`, `update`, and
  domain abilities such as `attempt`, `manageStudents`, `sendMessage`.
- Call it: `$this->authorize(...)` in controllers, `Gate::authorize(...)` in Actions or Livewire.
- **Visibility goes in the query**, not only in the Policy. A Policy protects a single record; a
  `visibleTo` scope protects a list (own grade, own class, published only). You need both.
- Never compare a role inline. Ask the enum (`$user->role->canTeach()`) or the Policy.

## Validation

- FormRequest for controller endpoints; `#[Validate]` attributes or a `rules()` method for Livewire.
- Validate on the server, always, even when the UI already prevents it.
- Business rules that need a query become custom rule objects in `app/Rules/`, not inline closures
  repeated in three places.
- Validation messages come from `lang/vi/validation.php` — attribute names must be translated or
  users see `curriculum_unit_id` in an error.

## AI calls

- Only through `App\Services\Ai\OpenRouterClient`, only from an Action.
- Send learning content and the conversation text — never a name, username or other personal field.
- The prompt states the level (A1–A2), the setting (Vietnam) and, for generated content, the unit's
  vocabulary and the rule that no textbook text may be reproduced.
- Parse AI output defensively: clamp numbers, drop malformed items, and never store a half-parsed
  result.
- Tests use `Http::fake` and assert on what was sent.

## Transactions and failure

- Any operation writing more than one row: `DB::transaction(fn () => ...)`.
- Throw a domain exception (`AiUnavailableException`, `RoleplayTurnLimitReachedException`) rather
  than returning `false`, and show the user a friendly message for it.
- Never swallow an exception with an empty `catch`. Log with context or rethrow.

## Localisation

- Every interface string: `__('curriculum.focus_saved')`.
- Keys live in `lang/vi/*.php` (primary) and `lang/en/*.php`. The interface language is per user.
- Learning content (English sentence + Vietnamese meaning) is data, not a translation key.
- Dates displayed `d/m/Y H:i` in `config('app.display_timezone')`, stored UTC.

## Things that are banned here

- The repository pattern wrapped around Eloquent. Eloquent is the data layer.
- Facades inside Actions where constructor injection is available — except `DB` and `Log`.
- `env()` outside `config/`. Use `config('...')`; `env()` returns null once config is cached.
- `->get()` inside a loop; any query inside a Blade loop.
- `dd()`, `dump()`, `ray()` in committed code.
- Raw SQL string interpolation. Bind parameters or use the query builder.
- Adding a package to solve something Laravel already does.

## Before you say you are done

```bash
vendor/bin/pint --dirty
php artisan test
```

Both must be clean. Report the real output.
