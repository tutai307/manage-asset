# Tech stack

Anything marked **Decided** is fixed until an ADR supersedes it. Anything marked **Open** must be
decided by an ADR before code depends on it.

---

## Decided

| Layer | Choice | Version installed | Rationale |
| --- | --- | --- | --- |
| Language | PHP | **8.2.12** (XAMPP) | The environment available on the customer's machine. Constrains the Laravel version. |
| Framework | Laravel | **12.64.0** | Latest that supports PHP 8.2. Laravel 13 requires PHP ≥ 8.3. |
| UI | Blade + Livewire | **4.3.3** | [ADR-0002](adr/0002-blade-livewire-over-inertia.md) |
| CSS | Tailwind CSS | **4.x** via `@tailwindcss/vite` | Ships with the Laravel 12 skeleton. Theme in `resources/css/app.css` with `@theme` — there is no `tailwind.config.js`. |
| Build | Vite | **7.x** | `npm run dev` / `npm run build` |
| Tests | PHPUnit | **11.5** | Ships with the skeleton. Not Pest — switching would be churn with no delivery value. |
| Formatter | Laravel Pint | **1.29** | Laravel preset, no custom rules. `vendor/bin/pint --dirty`. |
| Log viewer | Laravel Pail | 1.2 | Dev only |
| Dev DB | SQLite | `database/database.sqlite` | Zero setup; fine for development and the test suite. |

### The PHP 8.2 ceiling

Laravel 13 and an increasing number of packages require PHP 8.3+. Upgrading XAMPP's PHP is a real
option but it is a **customer environment decision**, not a unilateral one — it affects whatever
else runs on that machine. If a needed package requires 8.3, raise it as an ADR rather than
quietly pinning an old version of the package.

---

## Open — needs an ADR before any dependent code

| Decision | Why it matters | Blocks |
| --- | --- | --- |
| **Production database** (MySQL 8 via XAMPP vs PostgreSQL vs SQLite) | Collation for Vietnamese search, full-text search, concurrency during kiểm kê | Any vendor-specific SQL, search implementation |
| **Roles & permissions** (hand-rolled vs `spatie/laravel-permission`) | Department-scoped permissions are the core authorization rule | Every Policy, the whole user epic |
| **Audit / activity log** (hand-rolled history tables vs `spatie/laravel-activitylog`) | The register's value is its history | The first migration — retrofitting audit loses the period that matters |
| **Excel import/export** (`maatwebsite/excel` vs CSV only) | Every school has an existing spreadsheet; the committee wants exports | The import epic |
| **Barcode / QR labels** (which library, which symbology) | Usually the customer's top request for kiểm kê | The inventory epic |
| **File storage** (local disk vs cloud) for invoices, decision documents, photos | Access control and backup | Attachments |
| **Authentication starter** (hand-rolled vs a Laravel starter kit) | Speed vs control over the login screen | Sprint 1 |
| **Queues** (sync vs database driver) | Only needed if imports or reports get slow | Deferred until there is a reason |

Default position on all of these: **decide late, decide with evidence.** Do not install a package
before the story that needs it exists.

---

## Package policy

Before proposing a dependency, answer:
1. Can Laravel already do this in ~50 lines? If yes, no package.
2. Is it actively maintained and compatible with PHP 8.2 / Laravel 12?
3. Who upgrades it in two years, when the school's IT staff owns this?

If it passes, write an ADR. Packages are never added silently as part of a story.

---

## Local commands

```bash
composer run dev        # server + queue listener + Vite, together
php artisan serve
npm run dev
php artisan test
vendor/bin/pint --dirty
php artisan migrate
php artisan make:livewire assets.index
```

## Environment

`.env` is gitignored; `.env.example` is the contract. Any new key added to `.env` **must** be added
to `.env.example` with a safe placeholder in the same change — a missing key is a broken checkout
for the next person. Never a real credential in either file.
