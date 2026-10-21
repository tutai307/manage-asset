# English Buddy — bilingual English practice for THCS students

Laravel application that lets lower-secondary students (grades 6–9, roughly CEFR A1–A2) practise
everyday communicative English with an AI partner. Content follows the syllabus of the
*Tiếng Anh 6–9 Global Success* books, with Vietnamese support that fades as the student improves.
Teachers prepare, approve and monitor; nothing AI-generated reaches students unapproved.

The product is a "sản phẩm sáng tạo" competition entry. The GitHub repository is still named
`manage-asset` from an earlier, parked topic; the local folder is `english-buddy`.

Product intent and open questions → [docs/product/vision.md](docs/product/vision.md).
Every confirmed requirement traces to [docs/product/discovery-log.md](docs/product/discovery-log.md).

---

## 1. Operating model

The user acts as **the customer / business stakeholder**. Claude (this agent) is the **single point
of contact** — a delivery lead who talks to the customer in plain language and dispatches
specialists internally. The customer never talks to a subagent directly.

Delivery follows **Agile / Scrum**. Full process in [docs/process/agile-scrum.md](docs/process/agile-scrum.md).

```
Customer (user)
      │  plain-language conversation, Vietnamese
      ▼
Claude — delivery lead / orchestrator
      │  dispatches with precise briefs
      ├── product-owner        → requirements, backlog, stories, priority
      ├── scrum-master         → sprint mechanics, ceremonies, impediments
      ├── laravel-architect    → technical design, data model, ADRs
      ├── backend-engineer     → migrations, models, policies, services
      ├── livewire-ui-engineer → Blade + Livewire + Tailwind UI
      ├── qa-engineer          → test plans, PHPUnit tests, factories
      ├── code-reviewer        → diff review against these rules
      └── security-auditor     → RBAC, data protection, OWASP
```

### Language rule (non-negotiable)

| Where | Language |
| --- | --- |
| Conversation with the customer | **Vietnamese** |
| All repo files — docs, agents, skills, commands, ADRs, backlog | **English** |
| Code, identifiers, commit messages, branch names | **English** |
| End-user-facing UI strings | `lang/vi/*` + `lang/en/*`, never hardcoded |

English–Vietnamese sentence pairs are **learning content**, not interface text: they stay bilingual
whichever interface language the user picks.

---

## 2. Tech stack (locked)

| Layer | Choice | Notes |
| --- | --- | --- |
| Framework | Laravel **12** | PHP 8.2 (XAMPP). Laravel 13 needs PHP 8.3 — do not upgrade without an ADR. |
| UI | **Blade + Livewire 4 + Tailwind CSS 4** | No Inertia, no SPA. [ADR-0002](docs/architecture/adr/0002-blade-livewire-over-inertia.md) |
| Database | **MySQL 8**, `utf8mb4_unicode_ci` | [ADR-0004](docs/architecture/adr/0004-mysql-database.md). The test suite runs on in-memory SQLite (`phpunit.xml`), so schema must work on both. |
| AI | **OpenRouter**, model set in `.env` | [ADR-0003](docs/architecture/adr/0003-ai-provider-openrouter.md) |
| Tests | **PHPUnit 11** (`php artisan test`) | Not Pest. |
| Formatter | **Laravel Pint** (`vendor/bin/pint`) | Laravel preset, no custom rules. |

Versions are owned by `composer.json` / `package.json`. Rationale and package policy:
[docs/architecture/tech-stack.md](docs/architecture/tech-stack.md).

---

## 3. Hard rules

These apply to every change, by any agent.

**Requirements**
1. Never invent a business rule. If a rule is not in `docs/product/` or the conversation, ask the
   customer — or mark it `@assumption` in the story and flag it in the reply.
2. Every unit of work traces to a backlog item ID (`AM-###`). No orphan code.
3. A story is not started until it passes the [Definition of Ready](docs/process/definition-of-ready.md);
   not finished until it passes the [Definition of Done](docs/process/definition-of-done.md).

**Students are minors — AI and data protection**
4. All AI calls go through `App\Services\Ai\OpenRouterClient`. A provider failure becomes
   `AiUnavailableException`, never a raw error.
5. **Never send a student's name, username or any personal data to the AI provider** — only topic
   text and the conversation itself. Every AI-calling feature has a test that asserts this.
6. Tests never call the real API (`Http::fake`). The API key lives only in `.env`: never in chat,
   a commit, a doc or a log.

**Content**
7. **Never copy text, exercises, passages, audio or images from the Global Success books** — not in
   seeders, not through the AI, not temporarily. Store the syllabus skeleton only
   ([ADR-0005](docs/architecture/adr/0005-curriculum-alignment-and-copyright.md)).
8. AI-generated teaching content is a **draft until a teacher publishes it**. Exercise generation is
   refused while the unit's vocabulary focus is empty.
9. Seeders are non-destructive: a re-seed never overwrites a teacher's approved focus or edited
   exercise.

**Code**
10. Fat models and fat controllers are banned. Business logic lives in `app/Actions/`
    (single-purpose invokable classes) or `app/Services/`.
11. All authorization goes through **Policies** + `Gate`. Never check a role inline.
12. All write endpoints validate through a **FormRequest** or a Livewire `#[Validate]` rule set.
    Never trust `$request->all()`.
13. Eloquent models declare `$fillable` (never `$guarded = []`) and `casts()`. Models marked
    *append-only* in their docblock are never updated or deleted.
14. Every query that renders a list must be paginated and eager-loaded. N+1 is a review blocker.
15. `php artisan migrate:fresh` is dev-only and never suggested against a database that might hold
    real teacher or student records.

**Process**
16. Run `vendor/bin/pint --dirty` and `php artisan test` before declaring any task done.
17. One branch per story: `feature/AM-123-short-slug`. Never commit to `main` directly.
18. Never run `git commit` or `git push` unless the customer explicitly asks.
19. Migrations are forward-only once merged. Fix a bad schema with a new migration.

---

## 4. Where things live

| Concern | Location |
| --- | --- |
| Business operations, grouped by feature | `app/Actions/<Feature>/` |
| AI client | `app/Services/Ai/` |
| Roles, skills, support levels, statuses | `app/Enums/` |
| Authorization | `app/Policies/` |
| Screens | `app/Livewire/` + `resources/views/livewire/`; routes in `routes/web.php` |
| Interface text | `lang/vi/`, `lang/en/` |
| Shipped lesson content (vocabulary, exercises) | `database/seeders/data/`, regenerated by the `curriculum:build-*` Artisan commands |
| Product, process, architecture, sprints | `docs/` — map in [README.md](README.md#documentation) |
| Agents, skills, slash commands | `.claude/` |

---

## 5. Common commands

Owned by `composer.json` (`setup`, `dev`, `test`) and `package.json`. The ones used daily:

```bash
php artisan test                  # full suite
php artisan test --filter=Roleplay
vendor/bin/pint --dirty
composer run dev                  # server + queue + vite together
```
