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
- The AI provider, the model policy, or what is sent to the AI
- File storage location and access model
- Queue / scheduling infrastructure
- What content may be stored (copyright — ADR-0005)
- Hosting for the trial and the competition demo
- Anything the customer would be annoyed to discover we changed silently

Not required for: naming, folder layout, which utility class to use — that is convention, and
conventions live in the skills.

## Template

```markdown
# ADR-NNNN — <decision as a short imperative phrase>

- **Status:** Proposed | Accepted | Superseded by ADR-NNNN
- **Date:** YYYY-MM-DD
- **Deciders:** delivery lead, laravel-architect, customer (when they were consulted)
- **Supersedes:** — | ADR-NNNN

## Context
The forces at play: constraints, the requirement that triggered this, what is expensive to reverse.

## Decision
What we do, stated so a reviewer can check code against it.

## Evidence
Optional — measurements or spikes that informed the choice.

## Options considered
**A. <option> (chosen)** — benefits, then the cost we accept.
**B. <option>** — why rejected.

## Consequences
**Positive:** … **Negative:** … **Follow-up:** backlog IDs, if any.
```

Reference examples in this repository:
[ADR-0003](../../../docs/architecture/adr/0003-ai-provider-openrouter.md) (a decision backed by
measured evidence) and
[ADR-0005](../../../docs/architecture/adr/0005-curriculum-alignment-and-copyright.md) (a decision
driven by a legal constraint).

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
