# Discovery log

Append-only record of what the customer told us, when. **Never edit or delete an entry** — if
something turns out to be wrong, append a new entry that corrects it. This log is how we tell the
difference between "the customer said so" and "we assumed so", which is the difference that matters
when a requirement is disputed three sprints later.

One entry per session, newest at the bottom.

---

## Template

```markdown
## YYYY-MM-DD — Session N: <topic>

**Asked about:** the questions put to the customer
**Learned:**
- fact, in the customer's own words where possible
- fact
**Decided:** decisions that came out of this, and who made them
**Artefacts received:** files, photos, form templates — with where they are stored
**Open:** questions asked but not answered
**Assumptions made:** anything we filled in ourselves, and whether the customer was told
**Backlog impact:** items created, changed or parked
```

---

## 2026-07-29 — Session 0: project setup

**Asked about:** nothing yet — this entry records the starting state, not a customer conversation.

**Decided (by the delivery team, confirmed by the customer):**
- Laravel 12.64 on PHP 8.2, Blade + Livewire 4 + Tailwind 4, PHPUnit 11 — see
  [ADR-0002](../architecture/adr/0002-blade-livewire-over-inertia.md)
- Delivery follows Agile/Scrum with 1-week sprints; the customer is the sole stakeholder and
  talks to a single agent
- All repository documentation is written in English; conversation with the customer is Vietnamese

**Open — nothing about the problem domain is known yet.** Everything in `vision.md`, `personas.md`
and `glossary.md` is `_TBD_` or marked as an unconfirmed hypothesis. The five blocking questions are
listed at the bottom of [backlog.md](backlog.md).

**Assumptions made:** none about the domain. The stack decision is ours and is recorded as an ADR.

**Next:** run `/discovery` — session 0 questions (scale, school type, current process, the pain,
what success looks like).
