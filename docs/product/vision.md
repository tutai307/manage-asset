# Product vision — bilingual communicative English trainer

> **Status: direction confirmed, details partially filled.** `_TBD_` marks what the customer has not
> yet answered. Source of every confirmed fact: [discovery-log.md](discovery-log.md) (Sessions 4–5).
> The earlier electricity/AC topic is parked — see Sessions 1–3 of the log.
>
> Note: the repository is still named `manage-asset`; renaming is an open housekeeping decision.

---

## 1. The problem

Students at THPT Đông Mai learn English grammar and vocabulary but struggle to **use basic
communicative sentences** — to say something, respond, and hold a short exchange. Class time gives
each student very little speaking practice, practice at home has no partner and no feedback, and a
teacher cannot personally correct forty students.

A generic English app does not fix this: it is not aligned to what the class is learning, the
teacher cannot see or control it, and it gives no Vietnamese scaffolding for weaker students.

## 2. Who we are building for

| | Value |
| --- | --- |
| School | THPT Đông Mai, Quảng Ninh — public upper secondary |
| Real audience | A **"sản phẩm sáng tạo" competition jury**; AI use is expected to raise creativity |
| Subject | **English** — basic communicative sentences |
| Users | Students (learn/practise) and English teachers (prepare, approve, monitor) |
| Devices | **Computers**, at school or at home, no restriction |
| Grades / textbook | _TBD_ |
| Number of classes / students in a trial | _TBD_ |

## 3. The product in one flow

1. Teacher picks a communication **topic** (e.g. greetings, asking for directions, shopping).
2. AI **drafts a bilingual lesson pack**: key sentence patterns (EN ↔ VI), a model dialogue,
   situations for role-play, and a short quiz.
3. **Teacher reviews, edits and approves.** Nothing AI-generated reaches students unapproved.
4. Students learn with **Vietnamese support that fades** (full VI → hints only → English only) and
   **practise speaking with an AI role-play partner**, receiving feedback.
5. Teacher dashboard shows which sentence patterns the class gets wrong.

## 4. Features — PROPOSED, accepted in principle

**Foundation (thin):** login with teacher/student roles; classes; topics and lessons.

**Core (deep, AI-assisted):**
- AI-drafted lesson pack with teacher approval
- Bilingual sentence patterns with fading Vietnamese support and pronunciation (text-to-speech)
- **AI role-play conversation** in a situation, by text and by voice, with bilingual hints on request
- Feedback on the student's sentences: correctness, naturalness, suggested better phrasing
- Spaced-repetition review of sentence patterns
- Teacher dashboard: common mistakes per class and per pattern

**Stretch:** pronunciation scoring; student-created dialogues shared with the class.

## 5. Out of scope

Grammar-course content, full exams, parent accounts, mobile apps, payment.

## 6. Constraints

| | |
| --- | --- |
| Deadline | November 2026 — _exact date TBD_ |
| AI provider and budget | _TBD — who pays for API usage_ |
| Voice | Browser speech APIs on computers; exact browser support to be verified in a spike |
| Evidence for the jury | A trial with real students and a pre/post test — _TBD with the teacher_ |

Stack unchanged: PHP 8.2, Laravel 12, Blade + Livewire 4 + Tailwind 4 — see
[tech-stack.md](../architecture/tech-stack.md).

## 7. Data protection and AI safety

- Never send student names or personal data to the AI provider; send only the conversation text.
- AI output shown to students is constrained to the approved topic and level.
- Every AI-generated teaching item is teacher-approved before publication.

## 8. Riskiest assumptions

| # | Assumption | How we test it | Status |
| --- | --- | --- | --- |
| 1 | Students will practise at home without being forced | Usage logs during the trial | Open |
| 2 | AI feedback is accurate enough at this level | Teacher spot-checks a sample | Open |
| 3 | Browser voice recognition handles Vietnamese-accented English acceptably | Technical spike, week 1 | Open |
| 4 | There is time for a trial before submission | Depends on the exact deadline | Open |

## Vision statement

For English students at THPT Đông Mai who know words but cannot yet use them to communicate, the
product is an AI-assisted practice partner, prepared and approved by their teacher, that lets every
student rehearse real conversations with bilingual support that fades as they improve.
