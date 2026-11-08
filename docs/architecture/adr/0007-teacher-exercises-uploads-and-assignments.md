# ADR-0007 — Teacher-written exercises, reading uploaded tests, and class assignments

- **Status:** Accepted
- **Date:** 2026-10-25
- **Deciders:** customer, delivery lead

## Context

The customer found setting work for students hard to follow and too dependent on AI drafts of
uneven quality (discovery Session 17). Before this decision a teacher could only press "Create
practice" on a unit, edit the AI draft, and publish it. Publishing made it visible to every
student in the grade. There was no way to give work to one class, set a due date, or see who had
done it.

The customer asked to upload a photo or file of a test and have the system turn it into an
exercise. Two hard rules apply:

- **Copyright (rule 7, ADR-0005):** a photographed Global Success page turned into an exercise is
  a copy of the book.
- **Minors' data (rule 5):** a photo sent to the AI can contain a student's name or handwriting.

## Decision

1. **Ownership.** `skill_exercises.owner_id` marks an exercise a teacher wrote (`source` = manual)
   or uploaded (`source` = upload). Owned exercises are visible only to their owner (and an
   administrator), and to students of classes they are assigned to. Open unit practice
   (`owner_id` null) works as before. One rule decides visibility, `SkillExercise::scopeVisibleTo`,
   and `SkillExercisePolicy` reuses it. `curriculum_unit_id` becomes optional, with `grade` for
   a test that spans units.
2. **Assignments.** An `assignments` row gives one exercise to one class, with an optional due
   date, stored in UTC and entered in `app.display_timezone`. Assigning publishes the exercise. It
   is refused while the exercise has no questions or still has questions marked `needs_check`.
   Results are counted from `exercise_attempts`; nothing is copied.
3. **Question types.** Added: `reorder`, `rewrite` (with `accepted_answers`), `matching` (one
   question per pair, shared options) and `pronunciation` (the underlined part written in
   `[brackets]`, rendered by `<x-marked>`). There is also a new skill, `language` (vocabulary
   and grammar), which the AI never drafts.
4. **Reading an upload** (`ReadExerciseFromUpload`): up to 5 photos or one PDF of a test, 10 MB
   each.
   - The AI is told to **transcribe, never write**: keep the teacher's questions and order, report
     anything that fits no type as "skipped", mark every guessed answer or unclear question
     `needs_check`, ignore handwriting and names, and flag a page that looks like a textbook.
   - The server checks each question again and keeps it but marks it when its answer is not
     among its options, a reorder answer uses other words, or an underlined-part question has no
     `[marks]`.
   - The result is a draft the teacher checks beside the original. Saving clears the marks.
5. **Guards.**
   - **Copyright:** the teacher must confirm that the test is their own or their school's, not
     from the Global Success books. The AI's "looks like a textbook" flag is shown as a warning.
   - **Students' data:** the teacher must confirm the test is blank. Photos are re-encoded with
     GD before they are stored or sent, which drops EXIF (GPS, camera, time), applies the
     orientation and limits the long side to 2000 px. Only the files and the kind of exercise
     reach the AI, never the teacher's or a student's name; a test asserts this.
6. **Model and files.** Uploads use `OPENROUTER_VISION_MODEL`, falling back to the chat model
   (`anthropic/claude-haiku-4.5` reads images and PDFs), with `OPENROUTER_VISION_TIMEOUT`
   (120 s). Files live on the private `local` disk under `exercise-sources/`. They are served
   only to whoever may edit the exercise, and deleted if reading fails.

## Evidence (2026-10-25, live API)

We wrote a 10-question grade 7 test of our own, with all seven types and one drawing task, and
uploaded it as a PNG and as a PDF:

- Each upload was read in 12–14 s, and all 10 questions came back with the right type.
- The drawing task was reported as skipped, and the two pronunciation questions (no answer key)
  came back marked for checking.
- After the prompt fixes below, a student who answered everything correctly in the browser
  (word tiles, matching lists, the rewrite typed as its continuation) scored 10/10, and the
  teacher's results page showed the score.

The first runs found two prompt defects, both fixed and covered by tests:

- A rewrite answer held only the continuation of the sentence.
- A pronunciation question had its `[marks]` in the stem instead of in the options.

### Amendment — 2026-10-25, discovery Session 18

- An exercise the AI drafts from the unit page is owned by the teacher who pressed the button, like a
  manual or uploaded one. Exercises have no draft badge or publish button any more.
- **Assigning no longer publishes.** An assignment shows the exercise to that class only, through
  `scopeVisibleTo`, so assigning an unreviewed open draft cannot expose it to the whole grade.
- `DeleteExercise` removes an exercise with its questions, assignments and original files. It is
  allowed for the owner, an administrator, or an open draft nobody owns. It is refused once a
  student has an attempt, so no results are lost. `DeleteTopic` follows the same rule for speaking
  lessons.

## Options considered

- **Allow textbook pages too.** Rejected by the customer: it would break ADR-0005 and the entry's
  "original, teacher-approved content" claim.
- **Word (.docx) files.** Deferred: they need a parsing package. Photos and PDFs cover the case.
- **OCR on the server, then text to the AI.** Rejected: it loses layout, so underlines, columns
  and matching, which the vision model reads directly.

## Consequences

- AI-drafted unit practice stays available, but is now one of three ways to create an exercise.
- Railway's filesystem is wiped on redeploy, so originals can disappear. The exercise is
  unaffected and the editor says the original is gone. Durable storage (S3 or a volume) is a
  later decision.
- Each upload is one vision call. That is cheap per test but counts against the AI budget in
  discovery Session 15.
