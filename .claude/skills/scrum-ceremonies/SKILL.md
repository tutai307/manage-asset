---
name: scrum-ceremonies
description: Templates and facilitation scripts for sprint planning, the daily roll-up, sprint review with the customer, and the retrospective — plus the velocity table. Load at any sprint boundary, when reporting progress, or when opening/closing a sprint.
---

# Ceremonies

Adapted for a one-agent-team with a human customer. The ceremonies are kept because their *purpose*
survives the small team: commit deliberately, make progress visible, show working software, improve.

Sprint length on this project: **1 week** (see `docs/process/agile-scrum.md`).
All sprint artefacts live in `docs/sprints/sprint-NN/`.

---

## 1. Sprint planning

**Purpose:** agree one goal and a commitment the team can actually hit.

Sequence:
1. Close the previous sprint first — nothing carries silently.
2. `product-owner` presents the top of the backlog in priority order.
3. Filter every candidate through the **Definition of Ready**. Anything failing is removed from the
   candidate list and named in the plan as removed, with the reason.
4. Agree a **sprint goal**: one sentence, in the customer's language, describing an outcome.
   - Good: "A student can take the unit test for their own unit and see their score."
   - Bad: "Complete AM-003, AM-004, AM-007."
5. Estimate anything unestimated. Split anything at 13.
6. Commit up to the capacity number. Under-commit in sprint 1–2.
7. Confirm the commitment with the customer before work starts.

### `goal.md`

```markdown
# Sprint N — YYYY-MM-DD → YYYY-MM-DD   (illustrative example)

## Goal
A teacher can give the pre-test to a class and see each student's result.

## Committed
| ID | Title | SP | Priority |
| --- | --- | --- | --- |
| AM-1xx | Teacher opens the pre-test for a class | 3 | Must |
| AM-1xy | Student takes the pre-test once | 5 | Must |
| AM-1xz | Class result table for the teacher | 3 | Should |
| **Total** | | **11** | |

## Capacity
Previous velocity: 12, 10, — · Committed: 11 · Buffer: bug fixes from sprint 2

## Not included, and why
- Post-test comparison — needs the pre-test results first
- Printable result sheet — the teacher has not said what the jury needs

## Risks
- The test questions come from the teacher; if they arrive late, day 1 is spent on seed data
```

---

## 2. Daily roll-up

Not a meeting — a written state update, on request or at the start of a working session.
Three questions, answered against the **goal**:

```markdown
### Day 3 — Sprint N   (illustrative example)

**On track for the goal?** At risk.
**Done since last:** AM-1xx merged and green.
**In flight:** AM-1xy — speech recognition fails on the school's older Chrome version.
**Blocked:** need to know whether the test may be retaken. Asked the customer, no answer yet.
**Action:** proceeding with one attempt only, marked as an assumption; small rework if retakes are allowed.
```

If the answer to the first question is "No", say so on the day you know — not at the review.

---

## 3. Sprint review (with the customer)

**Purpose:** show working software and get a real accept/reject.

Structure:
1. Restate the goal.
2. Demo each completed story against its **acceptance criteria** — walk the actual scenarios, not a
   summary. Show the negative case too, especially the permission one.
3. Show what was **not** completed, plainly, with the reason.
4. Collect feedback. New requests become backlog items, not silent scope.
5. Get an explicit decision per story: **Accepted** or **Rejected, because…**

### `review.md`

```markdown
# Sprint N review — YYYY-MM-DD   (illustrative example)

## Goal: achieved / partially achieved / not achieved
Partially — students can take the test; the class result table is not started.

## Demonstrated
| ID | Result | Customer feedback |
| --- | --- | --- |
| AM-1xx | Accepted | — |
| AM-1xy | Accepted with change request | Wants a timer on the test → new item |
| AM-1xz | Not started | Moved to the next sprint |

## New backlog items from this review
- Show a countdown timer during the test (Should, 2 SP)
- Export class results for the competition entry (Must — the customer says the jury needs it)

## Decisions
- Students take the test at school only, not at home. Assumption closed.
```

---

## 4. Retrospective

**Purpose:** change one thing that will measurably help next sprint.

Base it on evidence: `board.md`, `git log`, the review outcome, test results. Not on vibes.

### `retro.md`

```markdown
# Sprint N retrospective   (illustrative example)

## Data
Committed 11 SP · Completed 8 SP · 1 story carried over · 2 bugs found after review

## Went well
- Splitting AM-1xy into "take the test" + "see the result" made it testable; the negative tests caught two real bugs.

## Did not go well
- Two days lost waiting on an unanswered customer question that was not escalated.
- AM-1xz was pulled into the sprint without a Ready check and turned out to need an unknown format.

## Actions
| # | Action | Owner | By |
| --- | --- | --- | --- |
| 1 | Escalate any unanswered customer question after 1 working day, in the daily roll-up | delivery lead | sprint 4 |
| 2 | No story enters the sprint without a recorded DoR check | scrum-master | sprint 4 |

## Carried forward
- From sprint 2: "add a permission test to every story" — done, keep.
```

Three actions maximum. Each has an owner and a deadline. Unactioned retro items are worse than no
retro, because they teach the team that the ceremony is theatre.

---

## 5. Velocity

`docs/sprints/README.md`:

```markdown
| Sprint | Dates | Goal | Committed | Built | Accepted | Notes |
| --- | --- | --- | --- | --- | --- | --- |
| N | <start → end> | <one-line goal> | <SP> | <SP built> | <SP accepted at review> | <carry-over, blockers> |
```

Velocity is a planning input, not a performance metric. Never compare it across projects, never
present it to the customer as productivity, and never inflate estimates to make it rise.
