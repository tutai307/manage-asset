# Discovery log

Append-only record of what the customer told us, when. **Never edit or delete an entry** — if
something turns out to be wrong, append a new entry that corrects it. This log is how we tell the
difference between "the customer said so" and "we assumed so", which is the difference that matters
when a requirement is disputed three sprints later.

One entry per session, newest at the bottom.

---

## Template

```markdown
## YYYY-MM-DD — Session N: <topic>

**Asked about:** the questions put to the customer
**Learned:**
- fact, in the customer's own words where possible
- fact
**Decided:** decisions that came out of this, and who made them
**Artefacts received:** files, photos, form templates — with where they are stored
**Open:** questions asked but not answered
**Assumptions made:** anything we filled in ourselves, and whether the customer was told
**Backlog impact:** items created, changed or parked
```

---

## 2026-07-29 — Session 0: project setup

**Asked about:** nothing yet — this entry records the starting state, not a customer conversation.

**Decided (by the delivery team, confirmed by the customer):**
- Laravel 12.64 on PHP 8.2, Blade + Livewire 4 + Tailwind 4, PHPUnit 11 — see
  [ADR-0002](../architecture/adr/0002-blade-livewire-over-inertia.md)
- Delivery follows Agile/Scrum with 1-week sprints; the customer is the sole stakeholder and
  talks to a single agent
- All repository documentation is written in English; conversation with the customer is Vietnamese

**Open — nothing about the problem domain is known yet.**

---

## 2026-07-29 → 07-30 — Sessions 1–3: the original topic (parked)

The first request was a different product for the same competition. It was replaced in Session 4
and is not part of English Buddy. The facts that still apply:

- The project is a **"sản phẩm sáng tạo" (creative/innovation) competition entry**. The real
  audience is the **jury**, so novelty and a visible, measured result matter more than
  administrative completeness.
- The full record of those sessions is in git history (commit `0d4c3a0`), should the topic ever
  return.

---

## 2026-09-17 — Session 4: topic change

**Learned — stated by the customer:**
- The competition topic has been **changed**. The new request: a **website that supports students
  learning bilingually (học song ngữ)**.
- The requesting teacher has **no clear requirements** and is relying on the customer to define the
  product.
- The customer has no product idea yet and asked for a proposed set of basic features for a
  competition entry, and whether AI should be used.

**Decided:** nothing yet. The electricity/AC direction (Sessions 1–3) is **parked, not deleted** —
it is kept in this log in case the topic change is reversed. `vision.md` still describes the old
topic and must be rewritten once the new direction is confirmed.

**Proposed by the delivery lead (awaiting the customer's decision):**
- One coherent pipeline rather than a feature list: teacher uploads a lesson → AI drafts a bilingual
  pack (subject glossary, scaffolded reading, quiz) → **teacher reviews and approves** → students
  learn with language support that fades over time → teacher dashboard shows which terms the class
  struggles with.
- AI is used where it does something a static site cannot, always with a teacher approval step
  before AI-generated content reaches students.

**Open (blocking):**
- Which competition, its rules and judging criteria; whether AI use is mandatory; submission date
  (previously November 2026 — still valid?).
- What "song ngữ" means at this school: teaching subjects (Maths, Physics…) in English, or learning
  English itself? Which subjects and grades?
- Students' devices and internet access at school.
- Whether to keep this repository (named `manage-asset`) or start a new one.

**Assumptions made:** none binding.

**Backlog impact:** none — the old direction is parked and the new one is not yet defined.

---

## 2026-09-17 — Session 5: new topic confirmed

**Learned — confirmed by the customer:**
1. The teacher's request, in the customer's words: software that helps students "học song ngữ bằng
   tiếng Anh bằng các câu lệnh cơ bản giao tiếp" — learning bilingually through **basic
   communicative English sentences/phrases**.
2. **Same competition** as before. **AI is expected** — it is there to raise the creativity score.
3. **Subject: English** (the English subject itself, not other subjects taught in English).
   → This corrects the Session 4 proposal, which assumed subject terminology (Maths, Physics…).
4. **Device: computer by default**, usable at school or at home; no restriction.
5. The customer **accepted the proposed direction** (teacher-approved, AI-drafted learning content
   with fading Vietnamese support and a teacher dashboard), now adapted to communicative English.

**Decided:**
- The electricity/AC topic (Sessions 1–3) is **parked**. `vision.md` rewritten for the new topic.
- The central AI feature becomes **role-play conversation practice** in everyday situations, since
  the goal is communication, not vocabulary lists.

**Open:**
- Exact submission date (previously "November 2026").
- Grade(s) and textbook in use (e.g. Global Success 10/11/12?) — decides the topic list.
- Meaning of "câu lệnh": everyday communicative sentences in general, or specifically classroom
  language/instructions? Delivery lead's reading: communicative sentence patterns.
- Who pays for AI API usage, and the budget.
- How many students/classes can join a trial, and whether the teacher will run a pre/post test.

**Assumptions made:** none binding.

**Backlog impact:** vision rewritten; epics to be drafted once grade/textbook and deadline are known.

---

## 2026-09-17 — Session 6: level, content, AI key, trial

**Learned — confirmed by the customer:**
1. **Deadline: as soon as possible.** No exact date given; plan for the shortest path to a usable
   product and a trial.
2. **Students are THCS (lower secondary, grades 6–9)**, not THPT. No specific textbook — the product
   builds **its own set of communication topics** aimed at improving everyday communication.
   ⚠️ Conflicts with Session 2 ("THPT Đông Mai"). Asked the customer to clarify; building for THCS
   level (roughly CEFR A1–A2) as instructed.
3. Confirmed reading of "câu lệnh cơ bản giao tiếp": **everyday communicative sentences**, not
   classroom instructions.
4. **AI: the customer provides an OpenRouter API key**, placed in `.env`. Cost is the customer's
   concern, not the delivery team's.
5. **The teacher agrees to a trial with 1–2 classes and a pre/post test.**

**Decided:**
- Backlog drafted (AM-E01..E06) and sprint 1 proposed — see `backlog.md` and `docs/sprints/sprint-01/`.
- The key is entered by the customer into `.env` (git-ignored); it is never pasted into chat,
  committed, or written into any doc.

**Assumptions made (flagged to customer):**
- Starter list of 12 THCS topics, drafted by the delivery team; teacher to review.
- Teacher creates student accounts (no public self-registration) — protects minors' data.

**Backlog impact:** AM-E01..E06, AM-001..AM-013, AM-T01..T02 created.

---

## 2026-09-18 — Session 7: mixed-language screens

**Learned:** the customer found the interface hard to use because English and Vietnamese were mixed
on the same screen, and asked for a proper multi-language mode (English and Vietnamese).

**Decided:** AM-014 added to sprint 1 — a VI/EN switch for the whole interface, remembered per
account. English and Vietnamese sentence pairs remain in both modes because they are the learning
content, not interface text.

**Backlog impact:** AM-014 created (3 SP), added to sprint 1.

---

## 2026-09-20 — Session 8: navigation and visual design

**Learned:** the customer found the product too plain, with no clear menu, and then judged the
first redesign "too gradient-heavy" and asked for UI/UX guidance to be applied properly.

**Decided:**
- AM-015 added to sprint 1: role-based dashboard, sidebar navigation, conversation history.
- Visual direction: one accent colour (steel blue), flat bordered surfaces, no gradients, semantic
  colour reserved for state, emoji used only as topic identity.
- The customer also asked for more features; a proposal list was given, nothing built yet.

**Open:** which of the proposed features to build after sprint 1.

**Backlog impact:** AM-015 created (5 SP).

---

## 2026-09-20 — Session 9: feature order approved

**Learned:** the customer approved the proposed order — voice practice, AI feedback, pre/post test,
teacher statistics — with "ok làm đi".

**Decided:** sprint 2 opened with AM-006, AM-007, AM-008 (hint added because it shares the screen
and the same AI client). AM-013 and AM-012 follow once the customer has seen these.

**Assumptions made:** hints are not stored, so they do not appear in teacher statistics yet; flagged
on AM-008.

**Backlog impact:** AM-006, AM-007, AM-008 detailed and built; AM-T02 closed inside AM-006.

---

## 2026-09-21 — Session 10: API key supplied

**Learned:** the customer put the OpenRouter key in `.env`.

**Decided:** ADR-0003 accepted with `anthropic/claude-haiku-4.5` after a measured comparison of
three models; `google/gemini-2.5-flash` recorded as the fallback.

**Backlog impact:** AM-T01 done. AM-005, AM-007, AM-008 verified against the live API.

---

## 2026-09-22 — Session 11: follow the Global Success books, grades 6-9

**Learned — from the customer:**
1. The product must cover **grades 6, 7, 8 and 9**, not one grade.
2. It must follow the **Tiếng Anh Global Success** books: practice for the **four skills** per unit,
   plus **review / practice tests / exams by unit and by term**.
3. Each grade gets its own content: a student sees the lessons of their own grade.
4. The customer asked the delivery team to fetch the book material from the internet.

**Decided:**
- ADR-0005: store the **syllabus structure only**; never copy text, exercises or audio from the
  books. All practice content is generated fresh and teacher-approved. This was put to the customer
  as a legal and competition-credibility matter.
- Unit titles for all four grades were looked up from public references and seeded (48 units).
  ⚠️ The teacher must still check them against the printed books.
- Phase 1 built now: syllabus browsing per grade, one-click AI drafting of a lesson pack per unit,
  teacher publish/unpublish.

**Open:** the four-skills practice and the test/exam engine are large; scope and order to be agreed
with the customer.

**Backlog impact:** AM-016 and AM-017 created and built; AM-E07 (four skills) and AM-E08
(tests and exams) created as epics to be broken down.

---

## 2026-09-23 — Session 12: "why is there no four-skills practice, and why is AI writing it?"

**Learned — the customer pushed back on two things:**
1. The four skills had been *listed* in the backlog, not built. Fair: only speaking (role-play) and
   a little listening (text-to-speech) existed.
2. "AI gen hộ" is not the same as following the book.

**Decided:**
- The delivery lead accepted both points. Content alignment is now anchored on **AM-022**: each unit
  holds the **vocabulary list and grammar point** that the class is learning, typed or approved by
  the teacher (AI may suggest a starting list, but `focus_approved` is only set when the teacher
  saves). Exercise generation is **refused** while that list is empty.
- Reading, listening and writing practice built this session, each restricted to the unit word list
  and marked automatically (writing is marked by the AI).
- ADR-0005 stands: the structure and the word list come from the teacher and public references; no
  textbook text, exercise or audio is copied.

**Backlog impact:** AM-022 created and built; AM-018, AM-019, AM-020 built. Sprint 3 opened.

---

## 2026-09-23 — Session 13: stop making teachers generate content

**Learned:** the customer asked for a **full seeder of lesson content for every grade**, with
teachers editing the parts they want — generating unit by unit with AI costs their time and effort.

**Decided (AM-023):**
- Content is drafted **once, by us**, with two commands, and the output is committed as seed data.
  A new installation gets 48 units of vocabulary and 144 exercises without any AI call.
- Seeders are non-destructive: a teachers approved word list or edited exercise is never
  overwritten on re-seed.
- Teachers can edit every part of an exercise in the UI, and generation remains available for extra
  material.

**Backlog impact:** AM-023 created and built; AM-009 closed (covered by AM-017).

---

## 2026-10-21 — Session 14: school level settled

**Learned — confirmed by the customer:** the product is for **THCS, grades 6–9**. This resolves the
conflict between Session 2 ("THPT Đông Mai") and Session 6. The school's name is not recorded until
the customer gives it.

**Decided:** `vision.md`, `CLAUDE.md` and the README describe THCS 6–9 only.

**Backlog impact:** none.
