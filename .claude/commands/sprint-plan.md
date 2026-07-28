---
description: Plan and open the next sprint
argument-hint: [sprint number — omit to auto-increment]
---

Plan sprint **$ARGUMENTS** (if omitted, the next number after the newest folder in `docs/sprints/`).

Dispatch `scrum-master`, which must load the `scrum-ceremonies` skill and:

1. **Close the previous sprint first** if it is still open. Nothing carries over silently — any
   incomplete item is named, and its remaining points restated.
2. Take candidates from the top of `docs/product/backlog.md` in priority order.
3. Run each through the **Definition of Ready**. Remove anything that fails and name the failure.
   Do not quietly fix a story to make it pass — send it back to `product-owner`.
4. Propose a one-sentence **sprint goal** in language the customer understands — an outcome, not a
   list of IDs.
5. Set the commitment against velocity from `docs/sprints/README.md`. If there is no velocity yet,
   commit deliberately small and label it "capacity unknown".
6. Write `docs/sprints/sprint-NN/goal.md` and initialise `board.md`.

Then present the plan to the customer **in Vietnamese**: the goal, what they will be able to do at
the end of the sprint, what was deliberately left out and why, and the risks.

**Ask for the customer's confirmation before any implementation starts.** A sprint the customer has
not agreed to is not a commitment.
