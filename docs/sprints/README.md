# Sprints

One folder per sprint: `sprint-01/`, `sprint-02/`, …

```
sprint-NN/
  goal.md     sprint goal, committed items, capacity, what was left out and why
  board.md    live status — the single source of truth for progress
  review.md   what was demoed, what the customer accepted or rejected
  retro.md    what happened, and at most 3 actions with owners
```

Templates and facilitation rules: the `scrum-ceremonies` skill.
Commands: `/sprint-plan`, `/sprint-status`, `/sprint-review`, `/retro`.

---

## Velocity

Updated at every sprint close by `scrum-master`.

| Sprint | Dates | Goal | Committed | Completed | Notes |
| --- | --- | --- | --- | --- | --- |
| — | — | _no sprint has started_ | — | — | Phase 0: discovery not yet done |

**Average velocity:** not established.

Velocity is a **planning input only**. It is not a productivity measure, it is never shown to the
customer as one, and estimates are never inflated to make it rise. Sprints 1 and 2 have no velocity
to plan against — commit small and label the commitment "capacity unknown".

---

## Before sprint 1

Sprint 1 does not open until the Phase 0 checklist in
[../process/agile-scrum.md](../process/agile-scrum.md) is complete — in particular the customer's
current Excel file or paper process, the scale numbers, and a first epic broken into `Ready`
stories.

When it does open, aim sprint 1 at the **thinnest vertical slice that proves the core model**:
one asset can be registered with a code, given a location, and found again. Not reporting, not
depreciation, not import. Everything else is easier to build once that slice is real and the
customer has seen it.
