---
name: laravel-conventions
description: Coding standards for this Laravel 12 / PHP 8.2 codebase — layering, naming, models, actions, policies, validation, enums, errors, localisation. Load before writing or reviewing any PHP in this project.
---

# Laravel conventions — manage-asset

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
  dependencies. Name it as a verb phrase: `TransferAsset`, `CloseInventorySession`, `DisposeAsset`.
- Use a `Service` only when several Actions share stateful coordination. Prefer Actions.
- Plain CRUD does not need an Action. Reserve them for operations with rules.

## Naming

| Thing | Convention | Example |
| --- | --- | --- |
| Model | singular PascalCase | `Asset`, `InventorySession` |
| Table | plural snake_case | `assets`, `inventory_sessions` |
| Pivot table | singular models, alphabetical | `asset_tag` |
| FK column | `<singular>_id` | `location_id`, `custodian_id` |
| Boolean column | `is_` / `has_` | `is_active`, `has_warranty` |
| Datetime column | `_at`; date-only `_date` | `disposed_at`, `acquisition_date` |
| Action | verb + noun | `TransferAsset` |
| Policy | `<Model>Policy` | `AssetPolicy` |
| Enum | singular PascalCase | `AssetStatus` |
| Test | `<Subject>Test` | `AssetTransferTest` |
| Route name | `resource.action` | `assets.index`, `assets.transfer` |

## Models

```php
class Asset extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['code', 'name', 'category_id', 'location_id', 'status', /* ... */];

    protected function casts(): array
    {
        return [
            'status'           => AssetStatus::class,
            'acquisition_date' => 'date',
            'original_value'   => 'decimal:2',
            'is_active'        => 'boolean',
        ];
    }
}
```

- `$fillable`, always. `$guarded = []` is banned.
- `casts()` method, not the `$casts` property (Laravel 11+).
- Relationships are typed: `public function location(): BelongsTo`.
- Query scopes for repeated filters: `scopeInService`, `scopeForDepartment`.
- No HTTP, no request access, no view rendering in a model.
- Global scopes only when the rule is genuinely universal — a forgotten global scope is very hard to
  debug. Prefer an explicit scope call.

## Enums

Backed enums in `app/Enums/`, always. Never a bare status string.

```php
enum AssetStatus: string
{
    case InUse      = 'in_use';
    case InStorage  = 'in_storage';
    case UnderRepair = 'under_repair';
    case Disposed   = 'disposed';

    public function label(): string
    {
        return __("asset.status.{$this->value}");
    }

    public function canBeTransferred(): bool
    {
        return in_array($this, [self::InUse, self::InStorage], true);
    }
}
```

Put transition rules on the enum where they are pure, so both the UI and the Action ask the same
question and cannot disagree.

## Authorization

- One Policy per model, methods matching the ability: `view`, `create`, `update`, `transfer`,
  `dispose`.
- Call it: `$this->authorize('transfer', $asset)` in controllers, `Gate::authorize(...)` in Actions
  or Livewire.
- **Department scoping goes in the query**, not only in the Policy. A Policy protects a single
  record; a scope protects a list. You need both.
- Never compare a role string inline. `if ($user->role === 'admin')` is a review blocker.

## Validation

- FormRequest for controller endpoints; `#[Validate]` attributes or a `rules()` method for Livewire.
- Validate on the server, always, even when the UI already prevents it.
- Business rules that need a query become custom rule objects in `app/Rules/`
  (`AssetIsTransferable`), not inline closures repeated in three places.
- Validation messages come from `lang/vi/validation.php` — attribute names must be translated or
  users see `location_id` in an error.

## Transactions and failure

- Any operation writing more than one row: `DB::transaction(fn () => ...)`.
- Throw a domain exception (`app/Exceptions/AssetNotTransferableException`) rather than returning
  `false`. Silent failure in an asset register means a lost record.
- Never swallow an exception with an empty `catch`. Log with context or rethrow.

## Localisation

- Every user-facing string: `__('asset.transfer.success')`.
- Keys live in `lang/vi/*.php` (primary) and `lang/en/*.php`.
- Dates displayed in `d/m/Y`; app timezone `Asia/Ho_Chi_Minh`, stored UTC.
- Numbers and money formatted with a helper, not inline `number_format` scattered through views.

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
