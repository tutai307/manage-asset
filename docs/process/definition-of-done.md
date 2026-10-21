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
- [ ] Models marked append-only (messages, reviews, attempts, reveals) are never updated or deleted
- [ ] Seeders never overwrite content a teacher has approved or edited
- [ ] Nothing hard-deletes a user or a class

**AI and student data**
- [ ] No student name, username or other personal data in any request to the AI provider — asserted by a test
- [ ] Tests fake the AI (`Http::fake`); the provider being down shows a friendly retry, not an error page
- [ ] AI-generated content stays a draft until a teacher publishes it

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

The users are **minors**, and the product puts AI output in front of them. A subtle defect does not
crash — it leaks a student's name to a third party, shows one class another class's work, or
publishes an unchecked AI exercise to forty children. That is why authorization tests, the
no-personal-data assertion and the negative cases are non-negotiable here rather than nice-to-have.
