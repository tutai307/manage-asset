# Git workflow

Repository: `https://github.com/tutai307/manage-asset.git`

---

## Branches

| Branch | Purpose |
| --- | --- |
| `main` | Always working. Every commit on it passes tests. Never committed to directly. |
| `feature/AM-###-short-slug` | One story. Branched from `main`, merged back when Done. |
| `fix/AM-B##-short-slug` | One bug. |
| `chore/short-slug` | Tooling, docs, config — no story ID needed. |

One branch per story. A branch that accumulates three stories cannot be reviewed, cannot be
reverted, and destroys the traceability from code back to a customer requirement.

```bash
git switch main && git pull
git switch -c feature/AM-021-unit-test
```

---

## Commits

Conventional Commits, with the story ID:

```
feat(AM-021): unit test built from the unit's vocabulary
fix(AM-B03): keep Vietnamese diacritics in generated vocabulary
test(AM-021): students cannot open another grade's test
docs: add ADR on hosting for the trial
chore: configure Pint in CI
refactor(AM-021): extract GradeUnitTest action from the Livewire component
```

- Present-tense imperative, lower case after the colon.
- Say **why**, not what — the diff already shows what.
- Small and coherent. One commit that touches a migration, a component and a test for the same
  behaviour is fine; one commit that does three unrelated things is not.
- Never commit `.env`, `database/database.sqlite`, `/vendor`, `/node_modules`, or real personal data.

---

## The rule that matters

**Claude never runs `git commit` or `git push` unless the customer asks for it.**

Not "as a helpful last step", not "to save your work". The customer decides when work is recorded
and published. Staging changes for review is fine; publishing them is their call.

The same applies to anything else outward-facing: opening a PR, creating an issue, pushing a tag.

---

## Merging

A story branch merges into `main` only when:
- `/dod-check AM-###` passes
- `php artisan test` is green **on the branch**
- `vendor/bin/pint --test` is clean
- `code-reviewer` has approved, and `security-auditor` too if auth, permissions, upload or import
  were touched

Prefer a merge commit or a squash that keeps the story ID in the subject, so `git log --grep=AM-021`
finds the whole story later.

---

## Migrations and history

- Once a migration is on `main`, it is immutable. Fix schema mistakes forward with a new migration.
- Never rewrite published history: no `push --force` on `main`, no rebase of a branch someone else
  has pulled.
- Never `git reset --hard` or `git checkout --` over uncommitted work without checking what is in it
  first.

---

## `.gitignore`

The Laravel defaults, plus anything that holds real data. If the customer sends a class list,
student results or a trial export, it goes in `docs/customer-data/` (gitignored) — **it contains
real children's names and must not enter the repository.**
