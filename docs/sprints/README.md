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

Updated at every sprint close by `scrum-master`. Source for each row: that sprint's `goal.md`.

| Sprint | Dates | Goal | Committed | Built | Accepted | Notes |
| --- | --- | --- | --- | --- | --- | --- |
| [1](sprint-01/goal.md) | 2026-09-18 → 09-24 | Sign in, study a topic with Vietnamese support, typed role-play | 22 SP | 27 SP | — | AM-014 and AM-015 added mid-sprint (+8). AM-T01 blocked on the API key, finished in sprint 2. |
| [2](sprint-02/goal.md) | 2026-09-21 → 09-27 | Speak instead of typing, hints, AI feedback | 12 SP | 25 SP | — | AM-T01 carried over; AM-016 and AM-017 added after discovery Session 11. |
| [3](sprint-03/goal.md) | 2026-09-23 → 09-29 | Four-skills practice tied to the unit's vocabulary | 29 SP | 37 SP | — | AM-023 added after discovery Session 13. |

**Average velocity:** not established. No sprint has been closed with a review or a retrospective,
so nothing has been formally accepted by the customer, and sprints 1–3 overlapped. Treat the
"Built" column as an upper bound, not a plan.

Velocity is a **planning input only**. It is not a productivity measure, it is never shown to the
customer as one, and estimates are never inflated to make it rise.

---

## Before the next sprint opens

Close sprints 1–3 properly first: a review with the customer (accept or reject each built item),
one retrospective, and a commitment no larger than what the review shows was accepted.
