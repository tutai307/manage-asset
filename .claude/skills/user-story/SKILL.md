---
name: user-story
description: The exact format for epics, user stories, Gherkin acceptance criteria, splitting and estimation used on this project. Load before writing or editing any backlog item, or when a request needs to be turned into buildable work.
---

# Writing stories for English Buddy

All stories live in `docs/product/backlog.md`. IDs are permanent and never reused:
epics `AM-E01`, stories `AM-001`, bugs `AM-B01`, technical enablers `AM-T01`.

---

## Story template

```markdown
### AM-0xx — Take the unit test for my unit   (illustrative example)

**Epic:** AM-E08 Tests and exams
**Status:** Ready · **Priority:** Must · **SP:** 5

**As a** student
**I want to** take a short test on the unit my class is studying
**So that** my teacher and I know whether I can use this unit's words and patterns

**Context**
The teacher gives one unit test per unit, usually in the last lesson of the unit. Today it is on
paper and marked by hand for forty students.

**Acceptance criteria**

Scenario: Student takes a published unit test
  Given unit 8 of grade 8 "Shopping" has a published unit test with 10 questions
  And I am signed in as a grade 8 student
  When I answer every question and hand in
  Then I see my score out of 10
  And an attempt is stored with my answers and score

Scenario: A draft test is not visible
  Given the unit test is still a draft
  When I open unit 8
  Then I do not see the test

Scenario: A student cannot open another grade's test
  Given I am a grade 7 student
  When I open the grade 8 unit test by its URL
  Then I receive a 404 response

**Permissions**
- student: own grade, published tests only
- teacher: preview any test, cannot hand in
- admin: as teacher

**Data**
Writes: one new row in `exercise_attempts` per hand-in. Append-only — a retake is a new row.
Nothing is sent to the AI for multiple-choice and gap-fill questions.

**Out of scope**
Term exams. A time limit.

**@assumption:** students may retake the test; every attempt is kept. Confirm with customer.
**❓ OPEN:** do students see the correct answers immediately after handing in?
```

---

## The narrative

`As a <specific role> I want to <capability> so that <business outcome>`

- The role is a **real role from `docs/product/personas.md`**, never "user".
- The outcome is a business result, never a restatement of the capability.
  Bad: "so that I can take a test." Good: "so that I know whether I can use this unit's words."
- If you cannot state a real "so that", the story may not be worth building. Say so.

## INVEST

| | Test |
| --- | --- |
| **I**ndependent | Can it be built without another unstarted story? If not, note the dependency explicitly. |
| **N**egotiable | It describes need and outcome, not a UI layout or a class design. |
| **V**aluable | Someone outside the dev team would notice if it shipped. |
| **E**stimable | The team can size it. If not, it needs a spike (`AM-T##`). |
| **S**mall | Fits comfortably inside one sprint, ideally a few days. |
| **T**estable | Every criterion is objectively pass/fail. |

## Acceptance criteria

Gherkin: `Given` (state) / `When` (action) / `Then` (observable result).

- **Every story needs a negative scenario and a permission scenario.** A story with only the happy
  path is not Ready. With minors' data, "who cannot see this" is as much a requirement as "who
  can".
- Criteria are observable: a status, a stored row, a message, an HTTP code. Never "the code should
  use a service class" — that is design, and it belongs to the architect.
- No vague adjectives. "Fast" → "the AI reply appears within 5 seconds, with a working state meanwhile".
- Concrete example data, with Vietnamese values where the field will hold Vietnamese, so encoding
  and diacritic problems surface in testing.

## Estimation

Modified Fibonacci: 1, 2, 3, 5, 8, 13.

| SP | Means |
| --- | --- |
| 1 | Trivial, well-understood, no new pattern (add a field to a form) |
| 2 | Small, follows an existing pattern exactly |
| 3 | Standard slice: model + component + tests, nothing new |
| 5 | New pattern, or several moving parts, or notable edge cases |
| 8 | Large, some uncertainty — consider splitting |
| 13 | Too big. **Split it.** Never commit a 13 to a sprint. |

Points measure effort and uncertainty together, not hours. Estimates come from the implementing
team, not from the Product Owner.

## Splitting a large story

Split by, in order of preference:
1. **Workflow step** — teacher prepares the test / student takes it / teacher sees results
2. **User role** — student first, teacher statistics later
3. **Operation** — list and view first, then create, then edit, then delete
4. **Rule complexity** — simple rule now, the exception cases as a follow-up
5. **Data scope** — one skill, one grade, then all

Never split into "backend story" + "frontend story". Each slice must be independently demoable.

## Bugs

```markdown
### AM-B0x — Vocabulary meaning loses Vietnamese diacritics   (illustrative example)

**Severity:** Major · **Found in:** Sprint 3 · **Status:** Ready
**Steps:** save the unit focus with the line "receipt (n) = hoá đơn"
**Expected:** the meaning shows "hoá đơn"
**Actual:** the meaning shows "hoa don"
**Impact:** every Vietnamese meaning students read is wrong
**Suspected:** normalisation in the vocabulary parser
```

Bugs are estimated and prioritised like stories. They are not "free work squeezed in".
