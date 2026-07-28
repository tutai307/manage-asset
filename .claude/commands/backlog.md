---
description: Show or groom the product backlog
argument-hint: [groom | show | ID to inspect]
---

Backlog operation: **$ARGUMENTS** (default: show)

Read `docs/product/backlog.md`.

**show** — present to the customer in Vietnamese: the top 10 items in priority order with ID, one
line each, status, priority and points. Then state how many items are `Draft` (not yet Ready) and
what is blocking them. Keep it scannable — a table, not prose.

**groom** — dispatch `product-owner` to:
- re-rank by WSJF-lite, with one sentence per moved item explaining the move
- split anything estimated at 8+ or unestimable
- promote `Draft` items to `Ready` where they now pass the Definition of Ready
- flag items that are stale or superseded and propose parking them

**an ID (e.g. AM-014)** — show the full story with its acceptance criteria and state whether it
passes the Definition of Ready, naming the specific criterion it fails if not.

Never silently reorder or delete items. Every change is reported to the customer with its reason.
