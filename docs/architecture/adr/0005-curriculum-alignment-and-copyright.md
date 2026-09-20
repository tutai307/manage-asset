# ADR-0005 — Follow the Global Success syllabus without copying it

- **Status:** Accepted
- **Date:** 2026-09-22
- **Deciders:** customer, delivery lead

## Context

The customer asked for the product to follow the **Tiếng Anh 6–9 "Global Success"** books
(NXB Giáo dục Việt Nam / Pearson): practice for all four skills per unit, reviews and tests per unit
and per term, and content specific to each grade (discovery Session 11).

Two things pull in opposite directions:

- Teachers adopt what fits the lesson they are teaching this week. Unit-aligned practice is the
  difference between a product a teacher uses and one they look at once.
- The books are **copyrighted**. Their reading passages, exercises, audio and artwork are not ours
  to reproduce, and a competition entry that republished them would be indefensible.

## Decision

1. Store only the **syllabus skeleton**: grade, unit number, unit topic (English and Vietnamese),
   term, and a short description of what the unit practises. Facts about the structure of a course
   are not the expressive content of the books.
2. **Never copy** text, exercises, reading passages, audio or images from the books, the workbooks,
   or teacher's editions — not in seeders, not through the AI, not "temporarily".
3. All practice material is **generated fresh** for the unit's topic and level, and is a **draft
   until a teacher publishes it** (`topics.status`). The generation prompt states the rule
   explicitly.
4. Listening practice uses the browser's speech synthesis over our own sentences, not the books'
   audio files.
5. Unit titles are recorded as published references state them; the teacher verifies them against
   the printed books before the trial.

## Consequences

- The product can say truthfully: "aligned to the syllabus, original content, teacher-approved" —
  which is also the stronger story for the jury than a digitised textbook.
- Content quality now depends on generation quality, so the teacher's review step is not optional.
- 48 units × several lessons is a lot of drafting, so generation must be one click per unit
  (AM-017) — measured at ~10s per unit against the live API.
- If the school later wants the exact textbook exercises, that needs a licence from the publisher.
  Out of scope for the competition entry.
