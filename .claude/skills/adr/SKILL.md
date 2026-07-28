---
name: adr
description: Format and rules for Architecture Decision Records on this project. Load when making or recording a decision that is expensive to reverse — a package, a database engine, an auth model, a storage or reporting strategy.
---

# Architecture Decision Records

An ADR records **why**, at a point in time, with the alternatives that were rejected. Code shows
what was built; only an ADR shows what was considered and discarded, which is what a future
maintainer actually needs.

Location: `docs/architecture/adr/NNNN-kebab-slug.md`, numbered sequentially from `0001`.

---

## When an ADR is required

- Adding a Composer or npm package that becomes load-bearing
- Choosing or changing the database engine
- Authentication / authorization model (roles vs permissions, package vs hand-rolled)
- Multi-tenancy or multi-school support
- File storage location and access model
- Queue / scheduling infrastructure
- Reporting or export strategy
- Audit-log strategy
- Anything the customer would be annoyed to discover we changed silently

Not required for: naming, folder layout, which utility class to use — that is convention, and
conventions live in the skills.

## Template

```markdown
# ADR-0004 — Use spatie/laravel-permission for roles and permissions

- **Status:** Accepted
- **Date:** 2026-08-12
- **Deciders:** delivery lead, laravel-architect, customer (consulted on role names)
- **Supersedes:** —

## Context

The school has 7 distinct roles and permissions are scoped by department. Role names are expected to
change as the school reorganises, so hardcoding them in code means a deployment for a policy change.
We need per-department scoping, which no off-the-shelf package handles for us.

## Decision

Use `spatie/laravel-permission` for the role/permission registry and assignment. Department scoping
is implemented in our own query scopes and Policies, not by the package.

## Options considered

**A. Hand-rolled roles column on users** — simplest, no dependency. Rejected: a single role per user
does not survive the auditor role, and every permission change becomes a migration.

**B. spatie/laravel-permission (chosen)** — mature, actively maintained, Laravel 12 compatible,
database-driven so roles change without a deploy. Cost: one more dependency, and its caching
behaviour is a known source of confusion in tests.

**C. Full policy-only approach with no registry** — most flexible. Rejected: every permission
question becomes bespoke code and the customer cannot see or change who can do what.

## Consequences

**Positive:** the customer can be shown a permission matrix; new roles need no code.
**Negative:** permission cache must be cleared in tests (`app()[PermissionRegistrar::class]->forgetCachedPermissions()`);
one more upgrade obligation.
**Follow-up:** AM-T07 — seed the initial role/permission matrix from the customer's answer.
```

## Rules

- **An ADR with one option is not a decision, it is a memo.** Record at least two real
  alternatives and why each was rejected. "We considered nothing else" is a valid finding but must
  be written down as such.
- Write the **context truthfully**, including constraints that are political or budgetary, not just
  technical. Those are usually the real reason.
- Statuses: `Proposed` → `Accepted` → `Deprecated` / `Superseded by ADR-NNNN`.
- **Never edit an accepted ADR to change the decision.** Write a new one that supersedes it and link
  both directions. The trail of changed minds is the point.
- Keep it to one page. If it needs more, the decision is probably several decisions.
- Link the ADR from the story or epic that triggered it, and from
  `docs/architecture/tech-stack.md` if it changes the stack.
