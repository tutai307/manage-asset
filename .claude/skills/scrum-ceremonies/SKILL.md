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
   - Good: "Asset managers can register an asset and find it again by code, room or category."
   - Bad: "Complete AM-003, AM-004, AM-007."
5. Estimate anything unestimated. Split anything at 13.
6. Commit up to the capacity number. Under-commit in sprint 1–2.
7. Confirm the commitment with the customer before work starts.

### `goal.md`

```markdown
# Sprint 3 — 2026-08-10 → 2026-08-16

## Goal
Asset managers can run a full inventory count on a phone and see the discrepancy list.

## Committed
| ID | Title | SP | Priority |
| --- | --- | --- | --- |
| AM-018 | Start an inventory session | 3 | Must |
| AM-019 | Scan/enter an asset code during a count | 5 | Must |
| AM-020 | Discrepancy report for a closed session | 3 | Should |
| **Total** | | **11** | |

## Capacity
Previous velocity: 12, 10, — · Committed: 11 · Buffer: bug fixes from sprint 2

## Not included, and why
- AM-021 Bulk transfer — blocked, waiting on the customer's approval-chain answer
- AM-034 Print the signed form — the customer has not sent the template yet

## Risks
- Barcode scanning on the school's Android devices is unverified → AM-T04 spike on day 1
```

---

## 2. Daily roll-up

Not a meeting — a written state update, on request or at the start of a working session.
Three questions, answered against the **goal**:

```markdown
### Day 3 — Sprint 3

**On track for the goal?** At risk.
**Done since last:** AM-018 merged and green.
**In flight:** AM-019 — the scanner library does not support the school's older browsers.
**Blocked:** need to know whether counting must work offline. Asked the customer, no answer yet.
**Action:** proceeding with online-only, marked as an assumption; will need rework if offline is required.
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
# Sprint 3 review — 2026-08-16

## Goal: achieved / partially achieved / not achieved
Partially — counting works, the discrepancy report is not started.

## Demonstrated
| ID | Result | Customer feedback |
| --- | --- | --- |
| AM-018 | Accepted | — |
| AM-019 | Accepted with change request | Wants the room pre-filled from the last scan → AM-041 |
| AM-020 | Not started | Moved to sprint 4 |

## New backlog items from this review
- AM-041 Remember the room between scans (Should, 2 SP)
- AM-042 Export the count result to Excel for the committee (Must — customer says this is required
  for the signed record)

## Decisions
- Offline counting is NOT needed — the school has wifi in all buildings. Assumption closed.
```

---

## 4. Retrospective

**Purpose:** change one thing that will measurably help next sprint.

Base it on evidence: `board.md`, `git log`, the review outcome, test results. Not on vibes.

### `retro.md`

```markdown
# Sprint 3 retrospective

## Data
Committed 11 SP · Completed 8 SP · 1 story carried over · 2 bugs found after review

## Went well
- Splitting AM-019 into scan + confirm made it testable; the negative tests caught two real bugs.

## Did not go well
- Two days lost waiting on an unanswered customer question that was not escalated.
- AM-020 was pulled into the sprint without a Ready check and turned out to need an unknown format.

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
| Sprint | Goal | Committed | Completed | Notes |
| --- | --- | --- | --- | --- |
| 1 | Asset CRUD skeleton | 8 | 8 | first sprint, deliberately small |
| 2 | Search and filtering | 12 | 10 | AM-011 carried over |
| 3 | Inventory counting | 11 | 8 | blocked 2 days on customer question |
| **Average** | | | **8.7** | use for sprint 4 planning |
```

Velocity is a planning input, not a performance metric. Never compare it across projects, never
present it to the customer as productivity, and never inflate estimates to make it rise.
