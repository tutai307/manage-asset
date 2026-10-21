# Definition of Ready

A story may enter a sprint only when **every** item below is true. The Scrum Master checks this at
planning; a story that fails goes back to the Product Owner rather than being patched in the room.

---

## Checklist

**Understanding**
- [ ] The narrative names a real role from `docs/product/personas.md` — not "user"
- [ ] The "so that" states a business outcome, not a restatement of the capability
- [ ] The customer has confirmed the need in their own words (linked in `discovery-log.md`)

**Acceptance criteria**
- [ ] Written in Gherkin, each objectively pass/fail
- [ ] Includes at least one **negative scenario** (the operation is correctly refused)
- [ ] Includes at least one **permission scenario** (who may not do this, and what they see)
- [ ] Uses concrete example data, with real Vietnamese values where the field holds Vietnamese
- [ ] No vague adjectives — "fast" is quantified, "user-friendly" is removed

**Rules and permissions**
- [ ] Every role's access to this operation is stated explicitly, including "no"
- [ ] Data scoping is stated: own records, own class, own grade, or everything?
- [ ] What happens on failure is stated: 403, 404, hidden UI, or an error message

**Data**
- [ ] Which tables and columns are written is known
- [ ] Whether the operation is reversible is stated
- [ ] Whether anything is sent to the AI is stated, and exactly which fields

**Practicalities**
- [ ] No unanswered `❓ OPEN` question that would change what gets built
- [ ] Any `@assumption` has been shown to the customer and not vetoed
- [ ] Dependencies on other stories are listed, and those stories are already done or in this sprint
- [ ] Estimated, and the estimate is ≤ 8 points (13 must be split)
- [ ] If it needs a design or a new package, the architect has produced one and any ADR exists
- [ ] If it needs an external artefact (the teacher's test paper, a class list format, a word list), that
      artefact is **in hand**, not promised

---

## Common reasons a story fails Ready on this project

- "AI generates the exercises" — with no statement of what the content must be restricted to (the
  unit's vocabulary), who approves it, or what happens when the AI is unavailable.
- A story that says "teacher manages the class" — create, add students, reset a password and see
  results are four operations with different rules hiding inside one line.
- Acceptance criteria that only describe the happy path. With minors' data, the refusals (another
  teacher's class, another student's work) are the requirement.
- A story that sends anything to the AI without saying exactly which fields are sent.
- A content story that would need text from the textbook itself (ADR-0005).

---

## The rule behind the rule

Ready means: **an engineer could build this, and QA could verify it, without asking the customer
anything.** If either would have to ask, it is not Ready — and the cost of finding that out mid-
sprint is far higher than the cost of one more question now.
