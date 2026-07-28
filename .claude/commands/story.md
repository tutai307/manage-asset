---
description: Turn a customer request into properly written backlog items
argument-hint: <the request, in the customer's own words>
---

Turn this request into backlog items: **$ARGUMENTS**

Dispatch the `product-owner` subagent. Give it: the request verbatim, the relevant part of
`docs/product/vision.md`, and anything the customer has already said on this topic from
`docs/product/discovery-log.md`.

It must produce, in `docs/product/backlog.md`:
- an epic if the request is larger than one story
- one or more stories in the project's story format, with Gherkin acceptance criteria including a
  negative case and a permission case
- explicit `@assumption:` lines for anything it had to fill in
- `❓ OPEN` questions for anything it could not

Then report back to the customer **in Vietnamese**:
- what will be built, in plain language, one line per story
- the questions you need answered before this can be estimated or started
- any assumption you made, so the customer can veto it

Do not estimate on the customer's behalf and do not start implementing.
