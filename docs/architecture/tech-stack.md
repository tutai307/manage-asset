# Tech stack

Anything marked **Decided** is fixed until an ADR supersedes it. Anything marked **Open** must be
decided by an ADR before code depends on it. Installed versions are owned by `composer.json`,
`composer.lock` and `package.json` — this file records why, not which patch release.

---

## Decided

| Layer | Choice | Rationale |
| --- | --- | --- |
| Language | PHP 8.2 (XAMPP) | The environment on the customer's machine. Constrains the Laravel version. |
| Framework | Laravel 12 | Latest that supports PHP 8.2. Laravel 13 requires PHP ≥ 8.3. |
| UI | Blade + Livewire 4 | [ADR-0002](adr/0002-blade-livewire-over-inertia.md) |
| CSS | Tailwind CSS 4 via `@tailwindcss/vite` | Ships with the Laravel 12 skeleton. Theme lives in `resources/css/app.css` with `@theme` — there is no `tailwind.config.js`. |
| Build | Vite | Ships with the skeleton. |
| Database | MySQL 8, `utf8mb4_unicode_ci` | [ADR-0004](adr/0004-mysql-database.md). Vietnamese text must round-trip exactly. |
| Test database | SQLite in memory | Set in `phpunit.xml`. Fast and isolated, so migrations must stay portable between SQLite and MySQL — no vendor-specific column types without an ADR. |
| AI | OpenRouter, model configured in `.env` | [ADR-0003](adr/0003-ai-provider-openrouter.md). Switching model is an `.env` change plus a re-run of `php artisan ai:compare-models`. |
| Speech | Browser Web Speech API (synthesis and recognition) | No server-side audio and no paid speech service. Recognition is feature-detected; the app must stay usable by typing. Not yet verified in a real browser session — see the sprint 2 and 3 goals. |
| Tests | PHPUnit 11 | Ships with the skeleton. Not Pest — switching would be churn with no delivery value. |
| Formatter | Laravel Pint | Laravel preset, no custom rules. |
| Authentication | Hand-rolled username sign-in | Students are minors without email addresses; teachers create their accounts (discovery Session 6). No starter kit. |
| Roles | `App\Enums\UserRole` + Policies | Three roles (admin, teacher, student) and class-scoped data. Small enough that a permissions package would add more than it removes. |

### The PHP 8.2 ceiling

Laravel 13 and an increasing number of packages require PHP 8.3+. Upgrading XAMPP's PHP is a real
option but it is a **customer environment decision**, not a unilateral one — it affects whatever
else runs on that machine. If a needed package requires 8.3, raise it as an ADR rather than
quietly pinning an old version of the package.

---

## Open — needs a decision before any dependent code

| Decision | Why it matters | Blocks |
| --- | --- | --- |
| **Hosting for the trial and the jury demo** | The AI needs internet access wherever the app runs; students must reach it from home | The trial (AM-013) |
| **Pronunciation scoring** (stretch) | Browser recognition gives text, not a score; a scoring service would add cost and send student audio to a third party | Any pronunciation story |

Default position: **decide late, decide with evidence.** Do not install a package before the story
that needs it exists.

---

## Package policy

Before proposing a dependency, answer:
1. Can Laravel already do this in ~50 lines? If yes, no package.
2. Is it actively maintained and compatible with PHP 8.2 / Laravel 12?
3. Who upgrades it in two years, when the school's IT staff owns this?

If it passes, write an ADR. Packages are never added silently as part of a story.

---

## Environment

`.env` is gitignored; `.env.example` is the contract. Any new key added to `.env` **must** be added
to `.env.example` with a safe placeholder in the same change — a missing key is a broken checkout
for the next person. Never a real credential in either file.
