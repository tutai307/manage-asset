---
name: discovery-interview
description: How to run a requirements conversation with the customer as a single point of contact — elicitation technique, a question bank for English Buddy (syllabus content, classes, tests, the trial, AI safety), how to record answers, and how to close discovery. Load at the start of the project, before each new epic, and whenever the customer describes a need in vague terms.
---

# Discovery interview

You are the customer's single point of contact. Discovery is a **conversation**, not a form. The
output is written requirements the team can build from.

Speak Vietnamese with the customer. Write everything down in English under `docs/product/`.

---

## The rules of the conversation

1. **Ask few questions at a time.** Three to five per turn, maximum. A wall of twenty questions
   gets three answered badly. Prioritise the ones that unblock the most work.
2. **Ask about the present, not the wish.** "How do you do this today?" beats "What do you want?".
   Customers describe solutions; you need the problem underneath.
3. **Ask for artefacts, not descriptions.** A page of the teacher's lesson plan, a sample unit test,
   the pre/post test, a screenshot of what confused a student. One real artefact is worth an hour of
   questions.
4. **Repeat back before building.** Summarise what you understood in the customer's own words and
   get an explicit yes. Misunderstandings are cheap now and expensive in sprint 4.
5. **Chase the exception.** Every process has one. "What happens when a student joins the class in
   the middle of the trial and missed the pre-test?" is where the real complexity lives.
6. **Record who decides.** For any rule involving approval or visibility, find out which role has
   authority. That role becomes a Policy.
7. **Never fill a gap with a guess.** If you must proceed, write `@assumption:` and say it out loud
   to the customer in your reply.
8. **Timebox.** Discovery that never ends is a failure mode. Get enough to start the next sprint on a thin
   slice, then keep discovering alongside delivery — that is the point of Agile.

---

## Before asking anything

Read `docs/product/vision.md` (the `_TBD_` rows), the **Open questions** table at the end of
`docs/product/backlog.md`, and the latest sessions of `docs/product/discovery-log.md`. Ask what is
still open; never re-ask what is already answered.

---

## Question bank by area

Draw from these as each epic comes up. Do not fire them all at once.

**Syllabus and content**
- Which unit is the class on this week? Can the teacher check our 48 unit titles against the
  printed books?
- Is the vocabulary list for this unit right? What is missing, what is too hard?
- Which starter topics does the teacher keep, drop or add?
- Is there any content the teacher must write themselves rather than approve from a draft?

**Classes and accounts**
- How many classes and students join the trial? Which grades?
- How are credentials handed to students — printed slips, read out, written in notebooks?
- What happens when a student forgets a password, changes class, or leaves the school?

**Tests and exams**
- What does a unit test look like today — how many questions, which types, how long?
- Is a term exam the same format as the school's real exam? Who sets it?
- Should students see the correct answers after submitting? Immediately, or after the deadline?

**Trial and evidence for the jury**
- What exactly is the pre/post test — who writes it, when is it run, how is it marked?
- What result would convince the jury? How many weeks of use are realistic before submission?
- May we show usage figures and anonymised examples of student work in the entry?

**Teacher statistics**
- What does the teacher want to know each week — who has not practised, which sentences are hard,
  scores per unit?
- Per student, or per class only? Who else may see it?

**AI and safety**
- Is the AI's level right for the class? Any reply the teacher found wrong or unsuitable?
- What should happen when a student types something inappropriate?

**Constraints**
- Where will the app run for the trial and for the jury — a school PC, a laptop, a hosted server?
  Is the internet reliable there?
- What is the submission date?
- Who looks after the app after the competition?

---

## Recording the answers

Every session updates:
- `docs/product/vision.md` — problem, users, success measures, scope boundaries
- `docs/product/glossary.md` — every new term the customer used, with their definition
- `docs/product/personas.md` — each user type and their real weekly workflow
- `docs/product/backlog.md` — new candidate items, status `Draft`

Append a dated log entry to `docs/product/discovery-log.md`:

```markdown
## YYYY-MM-DD — Session N: unit tests   (illustrative example, not a real session)

**Asked about:** unit test format, answer visibility, who sets the term exam
**Learned:**
- A unit test is 20 questions, 15 minutes, multiple choice and gap fill only
- Students see correct answers only after the teacher closes the test
**Decided:** unit tests before term exams — they are what the teacher uses weekly
**Open:** term exam format — the teacher will send last year's paper
**Assumptions made:** none
```

---

## Closing discovery for an epic

You have enough when you can answer, without guessing:
- Who does this, and who must not be able to?
- What are the exact steps, including the exception path?
- What data is captured at each step?
- How do we know it worked — what does the customer check?

Then hand off to `product-owner` to write the stories. If you still cannot answer one of those four,
say which one and ask that specific question instead of starting to build.
