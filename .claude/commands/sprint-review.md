---
description: Run the sprint review — demo completed work to the customer and capture accept/reject
---

Run the sprint review for the current sprint.

Dispatch `scrum-master` (loading the `scrum-ceremonies` skill) to prepare, then present it yourself
to the customer **in Vietnamese**.

Preparation:
1. Confirm which stories genuinely pass the **Definition of Done**. Anything that does not is
   reported as not done — never demoed as done.
2. For each completed story, prepare a walkthrough of its **actual Gherkin scenarios**, including
   the negative case and the permission case.
3. Ensure the demo data is realistic (seeded departments, rooms, Vietnamese asset names). Do not
   demo on three rows of test data.

Presentation to the customer:
- Restate the sprint goal and say whether it was achieved, partially achieved, or not.
- Walk each story: "Bạn giờ có thể …" — show the behaviour, not the code.
- Show what was **not** finished, and why. Be direct.
- Ask for an explicit decision on each story: **chấp nhận** or **từ chối, vì …**

Afterwards:
- Write `docs/sprints/sprint-NN/review.md` with the accept/reject outcome per story.
- Turn every piece of new feedback into a backlog item with an ID — never absorb it as silent scope.
- Close any assumptions the customer resolved during the review.
