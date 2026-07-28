---
description: Record an architecture decision as an ADR
argument-hint: <the decision, e.g. "database engine" or "role & permission model">
---

Record an architecture decision about: **$ARGUMENTS**

Dispatch `laravel-architect` with the `adr` skill loaded.

It must:
1. Read the existing ADRs in `docs/architecture/adr/` — check this is not already decided or
   contradicted by an earlier one.
2. Establish the real context: the constraints, including the non-technical ones (PHP 8.2 on XAMPP,
   a school IT team maintaining it, budget, deadline).
3. Present **at least two genuine alternatives** with their trade-offs. An ADR with one option is a
   memo, not a decision — if there truly was no alternative, write that explicitly.
4. Make a recommendation and state the consequences, including the negative ones.
5. Write `docs/architecture/adr/NNNN-slug.md`, next number in sequence, status `Proposed`.
6. Update `docs/architecture/tech-stack.md` if the stack changes.

Then explain the decision to the customer **in Vietnamese**, in business terms — what it costs, what
it enables, what it makes harder later. Move the status to `Accepted` only after the customer or the
delivery lead confirms.

Never change an accepted ADR to a new decision. Write a new ADR that supersedes it, and link both.
