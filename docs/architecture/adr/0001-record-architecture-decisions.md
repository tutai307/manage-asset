# ADR-0001 — Record architecture decisions

- **Status:** Accepted
- **Date:** 2026-07-29
- **Deciders:** delivery lead

## Context

`manage-asset` will be built incrementally against requirements that are not yet known, then handed
to a school's IT staff to maintain. Several decisions ahead of us are expensive to reverse: the
database engine, the permission model, how audit history is stored, how assets are identified.

Code records what was built. It does not record what was considered and rejected, or which
constraint forced a choice. Six months from now — or after a handover — that missing context is what
makes a maintainer either extend the system or rewrite it.

## Decision

Record every significant architecture decision as an Architecture Decision Record in
`docs/architecture/adr/NNNN-slug.md`, numbered sequentially, using the format in the `adr` skill.

An ADR is required for: packages that become load-bearing, the database engine, the
authentication/authorization model, multi-tenancy, file storage, queue infrastructure, the reporting
strategy, and the audit-log strategy.

An ADR is **not** required for conventions — naming, folder layout, which helper to use. Those live
in the skills under `.claude/skills/`.

Accepted ADRs are never edited to change their decision. A changed mind produces a new ADR that
supersedes the old one, linked in both directions.

## Options considered

**A. ADRs in the repository (chosen).** Versioned with the code, reviewable in the same diff,
available offline and after handover. Cost: discipline — an unwritten ADR is worse than no process,
because it creates false confidence that decisions are documented.

**B. Decisions captured only in the conversation with the customer.** Zero overhead. Rejected: the
conversation is not handed over with the codebase, and nobody can search it.

**C. A wiki or external document.** Familiar to non-technical stakeholders. Rejected: it drifts from
the code immediately, and this project has no existing wiki to build on.

## Consequences

**Positive:** decisions are reviewable, searchable and survive handover. The `laravel-architect`
agent has a defined output. Rejected options stop being re-proposed every few sprints.

**Negative:** a real cost per decision — roughly one page of writing. Mitigated by keeping ADRs
short and by not requiring them for conventions.

**Follow-up:** the open decisions listed in [tech-stack.md](../tech-stack.md) each need an ADR
before any code depends on them.
