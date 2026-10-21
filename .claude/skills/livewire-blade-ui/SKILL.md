---
name: livewire-blade-ui
description: UI conventions for this project — Livewire 4 component structure, Blade layout and components, Tailwind 4 theming, tables, forms, modals, flash messages, and Vietnamese-language UI requirements. Load before writing or reviewing any Blade or Livewire file.
---

# UI conventions — Blade + Livewire 4 + Tailwind 4

Installed: `livewire/livewire ^4.3`, `tailwindcss ^4`, Vite 7.

> **Livewire 4, not 3.** Livewire 4 generates single-file components by default, but this project
> uses class-based components (see File layout) — match them. Several v3 APIs have moved. When you are not certain of a signature or attribute, read
> `vendor/livewire/livewire/src/` or run `php artisan make:livewire Scratch` and look at the
> generated stub. Do not write from memory of Livewire 3 — the failure mode is silent.
> `php artisan livewire:convert` switches a component between single-file and multi-file.

---

## File layout

Components are **class-based**: a class in `app/Livewire/<Feature>/` and its view in
`resources/views/livewire/<feature>/`, routed with `Route::livewire(...)` in `routes/web.php`.
Follow that shape — do not mix in single-file components.

```
app/Livewire/Skills/ExercisePage.php      ↔  resources/views/livewire/skills/exercise-page.blade.php
resources/views/layouts/app.blade.php        the shell: sidebar navigation, locale switcher
resources/views/components/                  reusable Blade components (<x-icon>, <x-nav-link>, …)
```

Keep the folder structure mirroring the feature (classrooms, curriculum, topics, roleplay, skills),
not the technical type.

---

## Component responsibilities

A Livewire component may:
- hold view state (filters, sort, the record being edited)
- validate input
- call an Action or a query
- render

A Livewire component may **not**:
- contain a business rule ("a unit without vocabulary cannot generate exercises") — that lives in an Action or an
  Enum, so the rule holds for every caller
- perform multi-table writes directly — call an Action

**Security:** every public property is writable by the browser. Treat them as untrusted input.
Re-authorize on every action method:

```php
public function submit(): void
{
    $exercise = SkillExercise::findOrFail($this->exerciseId);
    Gate::authorize('attempt', $exercise);   // never trust $this->exerciseId alone
    // ...
}
```

Anything the user must not change goes in a computed property or is re-fetched, not a public
property. IDs, scores and correct answers held in public properties and trusted on submit are the
classic Livewire vulnerability — a correct answer in a public property is also visible to the
student in the page payload.

---

## Lists and tables

- `WithPagination`, always. `->paginate(25)` with `->with()` for every relationship the row renders.
- Search input: `wire:model.live.debounce.400ms`. Never `.live` with no debounce on a text field.
- `resetPage()` whenever a filter changes, or the user lands on an empty page 7.
- Sortable columns are `<button>`s with `aria-sort`, not clickable `<th>` text.
- Every table has: a loading state, an empty state that says what to do next, and a row count.
- Bulk selection stores IDs, and the bulk Action re-checks the Policy for **every** ID server-side.

## Forms

- One `<label for>` per input. Errors under the field via `@error`.
- Submit buttons: `wire:loading.attr="disabled"` plus `wire:target`, so a double click cannot double
  submit.
- `wire:model.blur` for text fields; `.live` only where instant feedback is genuinely needed.
- Success and failure both produce a visible message. A form that silently succeeds is a bug report
  waiting to happen.
- Destructive actions get a confirmation naming the record: "Đặt lại mật khẩu cho Nguyễn Văn An?" — never
  a bare `wire:click="delete"`, never `confirm()` alone as the only guard.

## Flash messages

One pattern for the whole app: dispatch an event from the component, render it in the layout.
Do not invent a second notification mechanism per screen.

## Tailwind 4

- Theme tokens are declared in `resources/css/app.css` with `@theme`. There is **no**
  `tailwind.config.js` in Tailwind 4 by default — do not create one out of habit.
- Utilities in the markup. `@apply` only for a pattern repeated 3+ times that cannot be a Blade
  component.
- Visual direction agreed with the customer (discovery Session 8): **one accent colour (steel
  blue), flat bordered surfaces, no gradients**. Semantic colour only for state (correct / wrong,
  draft / published). Emoji only as topic and unit identity.
- Never colour-only: pair every status colour with its text label.

## Accessibility and daily-use quality

Students aged 11–15 and their teachers use this, often on shared school computers. Treat these as
requirements, not polish.

- Actions are `<button>` or `<a>`. Never a clickable `<div>`.
- Keep the focus ring. Do not `outline-none` without an equivalent `focus-visible` style.
- Modals trap focus, close on `Escape`, and return focus to the trigger.
- Icon-only buttons get an `aria-label`.
- Tables have `<caption>` or a heading, and `<th scope>`.

## Vietnamese UI

- No hardcoded strings. `__('skills.result')`, keys in `lang/vi/` and `lang/en/`.
  The interface language switches per user; English–Vietnamese learning content stays bilingual
  in both modes.
- Speech (text-to-speech, recognition) is feature-detected; every screen still works by typing.
- Screens that wait for the AI show a working state and a friendly retry on failure.
- Vietnamese runs ~30% longer than English — test layouts with real Vietnamese labels, not
  placeholders. Fixed-width buttons and truncated table headers are the usual casualty.
- Verify diacritics render in the chosen font and survive search, sort and export.
- Dates `d/m/Y`. Thousands separator per the customer's preference — ask, do not assume.

## Verify

```bash
npm run build
php artisan test
vendor/bin/pint --dirty
```

If you have not run the page, say which parts are unverified rather than implying you saw it work.
