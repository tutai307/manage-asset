# Product vision — bilingual communicative English trainer

> **Status: direction confirmed, details partially filled.** `_TBD_` marks what the customer has not
> yet answered. Source of every confirmed fact: [discovery-log.md](discovery-log.md) (Sessions 4–13).
> The earlier electricity/AC topic is parked — see Sessions 1–3 of the log.
>
> Note: the GitHub repository is still named `manage-asset`; the local folder is `english-buddy`.

---

## 1. The problem

Lower-secondary (THCS) students learn English grammar and vocabulary but struggle to **use basic
communicative sentences** — to say something, respond, and hold a short exchange. Class time gives
each student very little speaking practice, practice at home has no partner and no feedback, and a
teacher cannot personally correct forty students.

A generic English app does not fix this: it is not aligned to what the class is learning, the
teacher cannot see or control it, and it gives no Vietnamese scaffolding for weaker students.

## 2. Who we are building for

| | Value |
| --- | --- |
| School | **THCS (lower secondary)**, grades 6–9 — confirmed by the customer, superseding the earlier "THPT" in Session 2. School name _TBD_. |
| Real audience | A **"sản phẩm sáng tạo" competition jury**; AI use is expected to raise creativity |
| Subject | **English** — basic communicative sentences |
| Users | Students (learn/practise) and English teachers (prepare, approve, monitor) |
| Devices | **Computers**, at school or at home, no restriction |
| Level | Roughly CEFR A1–A2 |
| Syllabus | **Tiếng Anh 6–9 Global Success** — 48 units; structure only, never the books' content ([ADR-0005](../architecture/adr/0005-curriculum-alignment-and-copyright.md)) |
| Trial | 1–2 classes, with a pre/post test run by the teacher |

## 3. The product in one flow

1. Each grade's **units** follow the syllabus. Every unit holds the **vocabulary and grammar** the
   class is learning, entered or approved by the teacher; ready-made content for all 48 units ships
   with the product so no teacher has to generate it.
2. Practice for the **four skills** is restricted to that vocabulary: reading, listening and
   writing exercises, and speaking through role-play on the unit's communication topics. AI can
   draft extra material.
3. **Teacher reviews, edits and publishes.** Nothing AI-generated reaches students unpublished.
4. Students learn with **Vietnamese support that fades** (full VI → hints only → English only) and
   **practise speaking with an AI role-play partner**, receiving feedback.
5. Teacher dashboard shows which sentence patterns the class gets wrong.

## 4. Features — accepted in principle

What is built and what is next is owned by [backlog.md](backlog.md); this list is the intended
shape of the product.

**Foundation (thin):** login with teacher/student roles; classes; VI/EN interface switch.

**Core (deep, AI-assisted):**
- Syllabus units per grade, each with a teacher-approved vocabulary and grammar focus
- Reading, listening and writing practice per unit, restricted to that focus; writing marked by AI
- Unit tests, review tests and term exams
- AI-drafted lesson pack with teacher approval
- Bilingual sentence patterns with fading Vietnamese support and pronunciation (text-to-speech)
- **AI role-play conversation** in a situation, by text and by voice, with bilingual hints on request
- Feedback on the student's sentences: correctness, naturalness, suggested better phrasing
- Spaced-repetition review of sentence patterns
- Teacher dashboard: common mistakes per class and per pattern

**Stretch:** pronunciation scoring; student-created dialogues shared with the class.

## 5. Out of scope

A grammar course, reproducing the textbooks' own exercises or audio (needs a publisher licence —
ADR-0005), parent accounts, mobile apps, payment.

## 6. Constraints

| | |
| --- | --- |
| Deadline | **As soon as possible** (Session 6); no exact submission date given — _TBD_ |
| AI provider and budget | **OpenRouter**; the customer supplies the key and pays for usage ([ADR-0003](../architecture/adr/0003-ai-provider-openrouter.md)) |
| Voice | Browser speech APIs on computers; recognition not yet verified in a real browser session |
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

For THCS students in grades 6–9 who know English words but cannot yet use them to communicate, the
product is an AI-assisted practice partner, prepared and approved by their teacher, that lets every
student rehearse real conversations with bilingual support that fades as they improve.
