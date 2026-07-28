---
name: user-story
description: The exact format for epics, user stories, Gherkin acceptance criteria, splitting and estimation used on this project. Load before writing or editing any backlog item, or when a request needs to be turned into buildable work.
---

# Writing stories for manage-asset

All stories live in `docs/product/backlog.md`. IDs are permanent and never reused:
epics `AM-E01`, stories `AM-001`, bugs `AM-B01`, technical enablers `AM-T01`.

---

## Story template

```markdown
### AM-014 — Transfer an asset to another room

**Epic:** AM-E02 Asset movement
**Status:** Ready · **Priority:** Must · **SP:** 5

**As a** asset manager
**I want to** move an asset from one room to another and record why
**So that** the register always reflects where equipment physically is

**Context**
Transfers happen ~30 times a month, mostly at the start of a term. Today they are recorded on a
paper form signed by both department heads.

**Acceptance criteria**

Scenario: Successful transfer
  Given an asset "MC-2024-013" is located in room "A201"
  And I am signed in as an asset manager
  When I transfer it to room "B105" with reason "Đổi phòng học"
  Then the asset's current location is "B105"
  And a transfer record exists with the previous location, the new location, my name and today's date
  And the asset's movement history shows the transfer

Scenario: Disposed assets cannot be transferred
  Given an asset has status "disposed"
  When I open its detail page
  Then the transfer action is not available
  And a direct transfer request is rejected with an authorization error

Scenario: A department head cannot transfer another department's asset
  Given I am a department head of "Tổ Toán"
  And an asset belongs to "Tổ Lý"
  When I attempt to transfer it
  Then I receive a 403 response
  And no transfer record is created

**Permissions**
- asset manager: yes, any asset
- department head: only assets of their own department
- teacher: no
- auditor: read the history only

**Data**
Writes: `assets.location_id`, new row in `asset_transfers`, `activity_log` entry.
Reversible: yes — by a second transfer. The original record is never edited or deleted.

**Out of scope**
Bulk transfer of many assets (AM-021). Generating the signed paper form (AM-034).

**@assumption:** no approval step is required for a same-building transfer. Confirm with customer.
**❓ OPEN:** does a transfer between departments need the receiving head's approval?
```

---

## The narrative

`As a <specific role> I want to <capability> so that <business outcome>`

- The role is a **real role from `docs/product/personas.md`**, never "user".
- The outcome is a business result, never a restatement of the capability.
  Bad: "so that I can transfer assets." Good: "so that the register reflects physical reality."
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
  path is not Ready. In an asset register, "who cannot do this" is as much a requirement as "who
  can".
- Criteria are observable: a status, a stored row, a message, an HTTP code. Never "the code should
  use a service class" — that is design, and it belongs to the architect.
- No vague adjectives. "Fast" → "the list of 5,000 assets renders in under 2 seconds".
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
1. **Workflow step** — create a transfer / approve it / print the form
2. **User role** — asset manager first, department head later
3. **Operation** — list and view first, then create, then edit, then delete
4. **Rule complexity** — simple rule now, the exception cases as a follow-up
5. **Data scope** — one category, one building, then all

Never split into "backend story" + "frontend story". Each slice must be independently demoable.

## Bugs

```markdown
### AM-B03 — Search misses assets with Vietnamese diacritics

**Severity:** Major · **Found in:** Sprint 3 · **Status:** Ready
**Steps:** search "Máy chiếu" on the asset list
**Expected:** returns the 12 projectors
**Actual:** returns 0
**Impact:** search is unusable for most asset names, which are Vietnamese
**Suspected:** collation on `assets.name`
```

Bugs are estimated and prioritised like stories. They are not "free work squeezed in".
