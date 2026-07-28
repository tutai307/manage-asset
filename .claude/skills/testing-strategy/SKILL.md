---
name: testing-strategy
description: How this project tests — PHPUnit 11 layout, what to test at which level, factories and seeders, Livewire component testing, authorization testing, and the Vietnamese data cases that must be covered. Load before writing tests or judging whether a story has enough coverage.
---

# Testing — manage-asset

PHPUnit 11 · Laravel 12 · SQLite in-memory for the suite · `php artisan test`.

---

## Shape of the suite

```
tests/
  Feature/            anything touching HTTP, Livewire, or the database
    Asset/AssetCrudTest.php
    Asset/AssetTransferTest.php
    Asset/AssetPolicyTest.php
    Inventory/InventorySessionTest.php
  Unit/               pure logic only — no DB, no framework
    Enums/AssetStatusTest.php
```

Most tests here are **Feature** tests. This is a CRUD-and-rules application; a unit test with the
database mocked out proves almost nothing about it. Unit tests are for enums, value objects,
calculations (depreciation) and pure helpers.

## What must be covered, in priority order

1. **Authorization, both directions.** For every protected operation: an authorised user succeeds
   *and* an unauthorised user is blocked. This is the highest-value test class in an internal admin
   app, because manual testing is always done as an admin and never catches it.
2. **State transitions.** Legal transitions work; illegal ones are refused. Disposed → in use must
   fail, and there must be a test proving it.
3. **Department scoping.** A department head sees their own department's assets and *not* another's
   — test the list query, not just the detail page.
4. **Data integrity.** Unique asset code, required relationships, soft-delete exclusion from lists,
   what happens to assets when a room is removed.
5. **Validation boundaries.** Negative value, disposal date before acquisition date, oversized
   upload, wrong MIME type, duplicate code.
6. **Vietnamese text.** Create with "Máy chiếu Sony VPL-EX430", then find it by searching "máy
   chiếu" (lowercase, and ideally without diacritics). Assert exact round-trip on read.
7. **Happy path.** Yes, last.

## Rules

- `use RefreshDatabase;` on every database test. Never `migrate:fresh` inside a test.
- Test names state behaviour: `test_department_head_cannot_transfer_another_departments_asset()`.
- One behaviour per test, Arrange / Act / Assert visibly separated by blank lines.
- **Assert on values you set.** A test that asserts on `fake()` output is flaky by construction.
  Use explicit factory state: `Asset::factory()->create(['code' => 'MC-2024-013'])`.
- Assert the **database**, not just the response: `assertDatabaseHas`, `assertSoftDeleted`,
  `assertDatabaseCount`.
- Would the test still pass if the feature were deleted? If yes, it is not a test. Asserting only
  `assertStatus(200)` is the usual offender.
- No sleeps, no order dependence, no shared state between tests.

## Factories

Every model gets a factory. Give it named states for the interesting cases:

```php
Asset::factory()->disposed()->create();
Asset::factory()->inRoom($room)->for($department)->create();
InventorySession::factory()->closed()->has(InventoryItem::factory()->count(50))->create();
```

Factories generate *valid* data by default. If a factory can produce a record that violates a
business rule, the factory is wrong and it will hide real bugs.

## Authorization test pattern

```php
public function test_teacher_cannot_dispose_an_asset(): void
{
    $teacher = User::factory()->teacher()->create();
    $asset   = Asset::factory()->inUse()->create();

    $this->actingAs($teacher)
        ->post(route('assets.dispose', $asset))
        ->assertForbidden();

    $this->assertDatabaseHas('assets', [
        'id'     => $asset->id,
        'status' => AssetStatus::InUse->value,
    ]);
}
```

Note the second assertion. Asserting the 403 alone does not prove nothing was written.

## Livewire tests

```php
Livewire::actingAs($manager)
    ->test(AssetIndex::class)
    ->set('search', 'Máy chiếu')
    ->assertSee('MC-2024-013')
    ->assertDontSee('BAN-2023-004');
```

- Test through the component API — `set`, `call`, `assertSee`, `assertDispatched`,
  `assertHasErrors`. Never regex over the rendered HTML.
- Test the guard, not just the flow: `->call('transfer')->assertForbidden()` for a user without the
  permission.

## Seeders

- `DatabaseSeeder` produces a realistic demo dataset for the sprint review: several departments,
  rooms, categories, a few hundred assets with Vietnamese names, one user per role. Reviews are
  unconvincing on three rows of Lorem Ipsum.
- Reference data (categories, statuses, roles) belongs in its **own idempotent seeder** that can be
  re-run against a real database without duplicating.
- No real personal data in seeders, ever.

## Reporting results

Run `php artisan test` and report the real numbers — tests, assertions, failures, duration. If the
suite is red, show the failure output and say what you believe is wrong. Never call a red suite
"mostly passing", and never delete, skip or weaken a test to make it green.
