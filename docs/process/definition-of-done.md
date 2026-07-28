# Definition of Done

A story is Done only when **every** item is verified with evidence. Verified by the Scrum Master via
`/dod-check AM-###`, never self-declared by the agent that wrote the code.

There is no "done except for tests" and no "done, will polish next sprint". Partially done is
**not done**.

---

## Checklist

**Function**
- [ ] Every acceptance criterion is implemented — each Gherkin scenario maps to code
- [ ] The negative scenarios genuinely fail as specified, not by accident
- [ ] Edge cases from the design are handled; failures produce a clear message, never silence

**Tests**
- [ ] An automated test exists for every acceptance criterion
- [ ] Authorization tested in both directions: permitted user succeeds, denied user is blocked
- [ ] `php artisan test` is **green** — actual output reported, not asserted
- [ ] New models have factories; new behaviour has a test that would fail if the feature were removed

**Code**
- [ ] `vendor/bin/pint --test` clean
- [ ] Layering respected: no business rules in Livewire components or controllers
- [ ] Authorization through Policies; no inline role-string comparison anywhere
- [ ] Server-side validation present, regardless of what the UI prevents
- [ ] No N+1 in any list this story touches; every list paginated and eager-loaded
- [ ] No `dd()`, `dump()`, `ray()`, commented-out code, or `TODO` without a backlog ID

**Data**
- [ ] Migration applies and rolls back cleanly
- [ ] Foreign keys have explicit `onDelete` behaviour and an index
- [ ] Money is `decimal`, never float
- [ ] Any change to an asset's location, custodian or status writes a history row
- [ ] Nothing hard-deletes a record of value

**Interface**
- [ ] `npm run build` succeeds
- [ ] All user-facing strings localised in `lang/vi/` and `lang/en/`
- [ ] Screen tested with real Vietnamese text — diacritics render, layout survives longer strings
- [ ] Loading, empty and error states exist
- [ ] Destructive actions require a confirmation that names the record
- [ ] Keyboard reachable; focus visible; status never conveyed by colour alone

**Review**
- [ ] `code-reviewer` verdict is Approve or Approve-with-minors, and minors are fixed or ticketed
- [ ] `security-auditor` has run **if** the story touched auth, permissions, upload or import, with
      no Critical or High findings outstanding

**Communication**
- [ ] Documentation updated where behaviour or the data model changed
- [ ] `board.md` updated
- [ ] Demoable end-to-end on seeded data that looks like a real school
- [ ] Any assumption made during implementation is written down and raised with the customer

---

## What Done does not require

- Deployment to production — that is a release decision, separate from Done
- 100% test coverage — coverage of the acceptance criteria and the failure paths is what matters
- Perfect visual design — but it must be usable, accessible and not embarrassing in a demo

---

## Why this bar

An asset register is a **system of record**. A subtle defect does not crash — it quietly records the
wrong location or loses a transfer, and nobody notices until the annual kiểm kê, by which point the
data cannot be reconstructed. That is why authorization tests, history rows and the negative cases
are non-negotiable here rather than nice-to-have.
