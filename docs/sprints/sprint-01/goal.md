# Sprint 1 — 2026-09-18 → 2026-09-24

**Status:** Active — confirmed by the customer 2026-09-17.

## Goal

A student can sign in, study the sentences of a communication topic with Vietnamese support, and
hold a short typed role-play with the AI on that topic.

## Committed (capacity unknown — first sprint)

| ID | Title | SP | Status |
| --- | --- | --- | --- |
| AM-T01 | Spike: OpenRouter integration and model choice | 3 | To do |
| AM-001 | Sign in as teacher or student | 3 | To do |
| AM-002 | Teacher creates a class and student accounts | 3 | To do |
| AM-003 | Starter communication topics | 3 | To do |
| AM-004 | Learn sentences with fading Vietnamese support | 5 | To do |
| AM-005 | Text role-play with AI | 5 | To do |
| | **Total** | **22** | |

## Left out, and why

Voice (AM-006) needs the AM-T02 spike first. Feedback (AM-007) builds on AM-005. Teacher authoring
(AM-009/010) is not needed to start a trial because starter content is seeded.

## Needed from the customer

- OpenRouter key entered as `OPENROUTER_API_KEY=` in `.env` (never pasted in chat) — before AM-T01.
- Confirmation of THCS vs THPT, and the teacher's view on the 12 starter topics.
