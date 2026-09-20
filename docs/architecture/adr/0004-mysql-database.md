# ADR-0004 — MySQL 8 as the application database

- **Status:** Accepted
- **Date:** 2026-09-18
- **Deciders:** customer, delivery lead

## Context

The scaffold used SQLite (`database/database.sqlite`). `CLAUDE.md` left the target database open,
with MySQL 8 as the likely choice. The customer asked on 2026-09-18 to use MySQL. A MySQL server is
already running on the development machine (port 3306).

## Decision

- Development and deployment use **MySQL 8**, database `english_buddy`, charset `utf8mb4`,
  collation `utf8mb4_unicode_ci` (Laravel's defaults in `config/database.php`), so Vietnamese
  diacritics are stored exactly.
- Credentials live only in `.env`. `.env.example` documents the keys with empty secrets.
- The **test suite stays on in-memory SQLite** (`phpunit.xml`) for speed and isolation. Migrations
  therefore remain portable: no raw vendor-specific SQL without a further ADR.

## Options considered

**A. MySQL 8 (chosen).** What the customer asked for; typical for shared/XAMPP hosting; handles
concurrent writes from a whole class during a trial better than a single SQLite file.

**B. Keep SQLite.** Zero setup, but a single file with limited concurrent writes is a risk when
40 students use role-play at the same time.

## Consequences

- Each developer creates the `english_buddy` database once before `php artisan migrate`.
- Behaviour that differs between SQLite and MySQL (case sensitivity, collation in `LIKE`/`unique`)
  is not caught by the test suite; check such features manually against MySQL.
