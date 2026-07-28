---
description: Run a requirements discovery session with the customer and record what was learned
argument-hint: [topic, e.g. "kiểm kê" or "phân quyền" — omit for session 0]
---

Run a discovery conversation with the customer about: **$ARGUMENTS**
(If no topic was given, this is session 0 — the foundational questions.)

Load the `discovery-interview` skill and follow it. Load `asset-domain` for context on what to
probe. Read `docs/product/discovery-log.md` first so you do not re-ask what has already been
answered.

Then:

1. Ask **3–5 questions**, in Vietnamese, prioritised by how much they unblock. Not a questionnaire.
2. Explain in one line why each matters, so the customer knows what it changes.
3. Ask for a real artefact if one is relevant (the current Excel file, a photo of an asset label, a
   blank statutory form, an example asset code).

When the customer answers, before asking anything further:
- Summarise back what you understood, in Vietnamese, and ask for confirmation.
- Update `docs/product/vision.md`, `glossary.md`, `personas.md` as appropriate.
- Append a dated entry to `docs/product/discovery-log.md`.
- Add any new candidate items to `docs/product/backlog.md` with status `Draft`.

Do not start designing or coding. Do not invent an answer to a question the customer has not
answered — record it as `❓ OPEN` and say so.
