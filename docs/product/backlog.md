# Product backlog

Ordered by value and risk, **not** by ID. IDs are permanent and never reused.

`AM-E##` epic · `AM-###` story · `AM-B##` bug · `AM-T##` technical enabler / spike

Statuses: `Draft` (captured, incomplete) · `Ready` (passes the Definition of Ready) ·
`In Sprint` · `Done` · `Parked`

> **The backlog is empty. This is intentional.**
> Requirements come from the customer, not from us. Run `/discovery` to start, then `/story` to
> turn what you learn into items. Nothing here is invented on the customer's behalf.

---

## Ordered backlog

| # | ID | Title | Type | Priority | SP | Status |
| --- | --- | --- | --- | --- | --- | --- |
| | | _empty — run `/discovery`_ | | | | |

---

## Epics

_None yet._

---

## Items

_None yet. Each item is written in the format defined by the `user-story` skill: narrative,
context, Gherkin acceptance criteria including a negative case and a permission case, permissions
per role, data touched, out-of-scope, and any `@assumption` / `❓ OPEN`._

---

## Parked

Items deliberately not being done, kept so they are not re-raised as new. Each records **why**.

_None yet._

---

## Open questions blocking the backlog

Questions whose answers change what we would build. Mirrored from `discovery-log.md`.

| # | Question | Blocks | Asked | Answered |
| --- | --- | --- | --- | --- |
| 1 | Public (công lập) or private school? Determines whether statutory asset regulation applies. | The whole financial epic | — | — |
| 2 | How many assets, rooms, departments and users? | Architecture, whether bulk tooling is essential | — | — |
| 3 | What does an existing asset code look like? (three real examples) | Asset identity model | — | — |
| 4 | Are identical items (e.g. 200 chairs) tracked individually or as a quantity? | The core data model | — | — |
| 5 | Can we see the current Excel file / paper process? | Everything — it is the real spec | — | — |

These five are the ones to ask first. Until 4 and 5 are answered, no schema should be written.
