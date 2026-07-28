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
- [ ] Department scoping is stated: does this see all records or only their own unit's?
- [ ] What happens on failure is stated: 403, 404, hidden UI, or an error message

**Data**
- [ ] Which tables and columns are written is known
- [ ] Whether the operation is reversible is stated
- [ ] Whether it must appear in the audit history is stated

**Practicalities**
- [ ] No unanswered `❓ OPEN` question that would change what gets built
- [ ] Any `@assumption` has been shown to the customer and not vetoed
- [ ] Dependencies on other stories are listed, and those stories are already done or in this sprint
- [ ] Estimated, and the estimate is ≤ 8 points (13 must be split)
- [ ] If it needs a design or a new package, the architect has produced one and any ADR exists
- [ ] If it needs an external artefact (a statutory form template, the customer's Excel file), that
      artefact is **in hand**, not promised

---

## Common reasons a story fails Ready on this project

- "The system should calculate depreciation" — with no confirmation of which method, which
  regulation, or which period the school uses.
- A report story where the customer has described the report but not supplied the actual form.
- A story that says "admin can manage assets" — four operations with four different permission
  rules hiding inside one line.
- Acceptance criteria that only describe the happy path. In an asset register, the refusals are the
  requirement.
- A story that depends on the asset code format, written before anyone looked at a real label.

---

## The rule behind the rule

Ready means: **an engineer could build this, and QA could verify it, without asking the customer
anything.** If either would have to ask, it is not Ready — and the cost of finding that out mid-
sprint is far higher than the cost of one more question now.
