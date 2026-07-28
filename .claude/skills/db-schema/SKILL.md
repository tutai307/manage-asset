---
name: db-schema
description: Database and migration conventions for this project — column types for the asset domain, naming, indexes and foreign keys, history/audit tables, soft deletes, money and dates, migration safety. Load before writing any migration or designing any table.
---

# Schema & migrations — manage-asset

Dev database: SQLite (`database/database.sqlite`). Production target: to be fixed by ADR — assume
MySQL 8 but **write portable migrations** until that ADR exists.

---

## Migration rules

- One migration per logical change. Never edit a migration that has been merged — fix it forward
  with a new one.
- `down()` must genuinely reverse `up()`. If it cannot (data loss), say so in a comment and make
  `down()` throw rather than silently doing something different.
- No `DB::statement` with vendor-specific SQL until the database ADR is written.
- Never `migrate:fresh` against anything that could contain real data. Not in a script, not in a
  suggestion to the customer.
- Seed data does not belong in a migration. Use an idempotent seeder.

## Column types for this domain

| Data | Type | Notes |
| --- | --- | --- |
| Asset code | `string(50)`, unique, indexed | Human-readable label ID. **Not** the primary key. |
| Serial number | `string(100)`, nullable | Vendor serial. Not unique — vendors repeat them. |
| Names, Vietnamese | `string(255)` | Ensure `utf8mb4` / `utf8mb4_unicode_ci` on MySQL. |
| Long text | `text` | Notes, reasons, discrepancy remarks. |
| Money | `decimal(15,2)` | **Never** `float`/`double`. 15 digits covers VND comfortably. |
| Quantity | `unsignedInteger` | |
| Status / condition | `string(30)` + PHP backed enum cast | Not a DB `enum` — altering those is painful. |
| Acquisition/disposal date | `date` | Date only; no spurious time component. |
| Event timestamp | `timestamp` | Store UTC. |
| Percentages / rates | `decimal(5,2)` | |
| Foreign key | `foreignId(...)->constrained()` | Always indexed, always explicit `onDelete`. |
| Files | `string` path + separate `attachments` table | Never store blobs in the database. |

## Foreign key behaviour — decide, do not default

State the intent for every FK:

| Relationship | Behaviour | Why |
| --- | --- | --- |
| `assets.location_id` → `locations` | `nullOnDelete()` or restrict | An asset must not vanish because a room was deleted. |
| `assets.category_id` → `asset_categories` | `restrictOnDelete()` | Prevent removing a category still in use. |
| `asset_transfers.asset_id` → `assets` | `cascadeOnDelete()` | History belongs to the asset — but the asset is soft-deleted, so this rarely fires. |
| `*.created_by` → `users` | `nullOnDelete()` | Never lose a record because a staff member left. |

Deleting reference data that is in use should fail loudly. A silent `SET NULL` on a category is how
a register quietly loses its structure.

## Indexes

Index, at minimum:
- every foreign key column
- `assets.code` (unique)
- anything used in `where` or `orderBy` on the asset list: `status`, `category_id`, `location_id`,
  `department_id`
- composite indexes for the real query shape: `['department_id', 'status']` — column order matters,
  put the equality filter first
- `inventory_items(['inventory_session_id', 'asset_id'])`, unique — an asset is counted once per
  session

Do not index everything. Every index slows writes and this system does bulk imports.

## History and audit — non-negotiable

An asset register is a system of record. Its value is the history, not the current row.

- Current state lives on `assets`. **Every change also appends a row to a history table.** Do not
  rely on the current column alone for location, custodian or status.
- History tables are **append-only**: no `updated_at` semantics, no edits, no deletes. If something
  was wrong, append a correcting entry.
- Every history row records: what changed, from, to, who (`user_id`), when, and why (`reason`,
  and where relevant a decision-document reference).
- A general `activity_log` covers everything else. Design it in from the first migration — adding
  audit after the fact means you have no history for the period that matters.

## Soft deletes

- `softDeletes()` on `assets`, `locations`, `departments`, `asset_categories`, `users`.
- Junction rows and drafts may be hard-deleted.
- History tables are **never** deleted, soft or hard.
- Remember: `unique` still collides with soft-deleted rows. For asset code, either use a composite
  unique with `deleted_at` or block reuse of retired codes deliberately — decide it, do not
  discover it in production.

## Standard table skeleton

```php
Schema::create('asset_transfers', function (Blueprint $table) {
    $table->id();
    $table->foreignId('asset_id')->constrained()->cascadeOnDelete();
    $table->foreignId('from_location_id')->nullable()->constrained('locations')->nullOnDelete();
    $table->foreignId('to_location_id')->constrained('locations')->restrictOnDelete();
    $table->foreignId('from_custodian_id')->nullable()->constrained('users')->nullOnDelete();
    $table->foreignId('to_custodian_id')->nullable()->constrained('users')->nullOnDelete();
    $table->date('transferred_on');
    $table->string('reason', 255);
    $table->string('decision_ref', 100)->nullable();   // số quyết định
    $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
    $table->timestamps();

    $table->index(['asset_id', 'transferred_on']);
});
```

## Before you commit a migration

- Does `php artisan migrate` then `php artisan migrate:rollback` work cleanly?
- Is there a factory for the new model, producing valid data?
- Does the change need a backfill for existing rows? Write it as a separate, idempotent, re-runnable
  command — not inside the migration.
