---
description: Honest progress report against the current sprint goal
---

Report the state of the current sprint.

Dispatch `scrum-master`. It must verify claims against evidence, not just read the board:
`docs/sprints/sprint-NN/board.md`, `git log --oneline`, `git status`, and `php artisan test`.

Report to the customer **in Vietnamese**, structured as:

1. **Sprint goal** — restated in one line.
2. **Will we hit it?** — Yes / At risk / No, and the specific reason. Answer this first, not last.
3. **Done** — completed stories, each with what the customer can now actually do.
4. **In progress** — what is being worked on and how far along.
5. **Blocked** — what is stuck, and the exact thing you need from the customer to unblock it.
6. **Scope changes** — anything added or dropped since planning, and who agreed to it.

Rules:
- If the sprint is slipping, say it plainly and say it now. A reassuring report that hides slippage
  is the most damaging thing you can produce here.
- Do not present task counts as progress. Progress is measured against the goal.
- Do not mark anything Done that has not passed the Definition of Done.
