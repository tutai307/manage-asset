---
description: Run the sprint retrospective and produce at most three concrete actions
---

Run the retrospective for the sprint that just closed.

Dispatch `scrum-master` with the `scrum-ceremonies` skill.

Base it on **evidence**, gathered before writing anything:
- `docs/sprints/sprint-NN/board.md` — what was committed vs completed, what carried over
- `docs/sprints/sprint-NN/review.md` — what the customer rejected or changed
- `git log --oneline` for the sprint window — where the work actually went
- `php artisan test` — current suite health
- bugs found after a story was called Done — these are the most informative signal available

Produce `docs/sprints/sprint-NN/retro.md` containing:
- **Data**: committed vs completed points, carry-over, bugs found post-Done, days blocked
- **Went well** — specific, with the evidence
- **Did not go well** — specific, with the evidence. Process failures, not blame.
- **Actions** — at most 3, each with an owner and the sprint it lands in
- **Carried forward** — unfinished actions from the previous retro, explicitly named as carried

Rules:
- Vague findings ("communication could be better") are not allowed. Name the moment it cost time.
- If an action from last retro was not done, say so rather than quietly re-listing it.
- Report the outcome to the customer in Vietnamese, focusing on the actions that affect them
  (for example: response time on blocking questions).
