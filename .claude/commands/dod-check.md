---
description: Verify a story against the Definition of Done before calling it complete
argument-hint: <story ID, e.g. AM-014>
---

Verify story **$ARGUMENTS** against the Definition of Done.

Read `docs/process/definition-of-done.md` and the story in `docs/product/backlog.md`.

Check each item **with evidence**, not by assertion. For every criterion, state PASS or FAIL and
name the file, line, test or command output that proves it:

1. Every acceptance criterion is implemented — map each Gherkin scenario to the code that satisfies
   it.
2. Every acceptance criterion has an automated test, including the negative and permission cases.
3. `php artisan test` — run it, report the actual numbers.
4. `vendor/bin/pint --test` — run it, report the result.
5. Authorization: Policy exists, is called, and visibility scoping (own class, own grade, published only) is applied in the query.
6. No N+1 in any list the story touches.
7. Migration is reversible; a factory exists for any new model.
8. User-facing strings are localised; the screen survives real Vietnamese text.
9. Documentation updated where the story changed behaviour or the data model.

Then dispatch `code-reviewer` on the diff, and `security-auditor` as well if the story touched
authentication, permissions, file upload or import.

Verdict, in Vietnamese to the customer: **Done** or **Not done**, and if not done, the specific
list of what remains. Do not mark a story Done in `board.md` on a partial pass — an item that is 90%
done is not done, and recording it as done is how a sprint silently fails.
