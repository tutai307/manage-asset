# Delivery process — Agile / Scrum

How work moves from a customer conversation to running software on `manage-asset`.

---

## 1. Who is who

| Scrum role | Who plays it here |
| --- | --- |
| Customer / Stakeholder | **The user.** Decides value and priority, accepts or rejects work. |
| Delivery lead | **Claude, the single agent.** The customer's only point of contact. Orchestrates everything below. |
| Product Owner | `product-owner` subagent — requirements, stories, backlog order |
| Scrum Master | `scrum-master` subagent — process, ceremonies, impediments |
| Development team | `laravel-architect`, `backend-engineer`, `livewire-ui-engineer`, `qa-engineer` |
| Quality gates | `code-reviewer`, `security-auditor` |

The customer never talks to a subagent. Every question and every report comes through the delivery
lead, in Vietnamese.

---

## 2. Cadence

- **Sprint length: 1 week.** Short, because the customer is available and feedback is the main
  risk-reduction tool on a project whose requirements are not yet known.
- Ceremonies are written artefacts, not meetings. They are triggered by slash commands.

```
/discovery ──▶ /story ──▶ /backlog groom ──▶ /sprint-plan ──▶ build ──▶ /dod-check
                  ▲                                                        │
                  │                                                        ▼
                  └────────────── /retro ◀── /sprint-review ◀──────────────┘
```

| Ceremony | Command | When |
| --- | --- | --- |
| Discovery | `/discovery [topic]` | Before each epic, and continuously |
| Backlog refinement | `/backlog groom` | Mid-sprint |
| Sprint planning | `/sprint-plan` | Start of sprint — needs customer confirmation |
| Daily roll-up | `/sprint-status` | On demand |
| Definition of Done check | `/dod-check AM-###` | Before any story is called done |
| Sprint review | `/sprint-review` | End of sprint — customer accepts or rejects |
| Retrospective | `/retro` | Immediately after the review |

---

## 3. Phase 0 — before sprint 1

Do not start sprint 1 until all of these exist:

- [ ] `docs/product/vision.md` filled in — the problem, the users, what success means
- [ ] `docs/product/personas.md` — every role that logs in, and what they do weekly
- [ ] `docs/product/glossary.md` — the customer's terms, in their words
- [ ] The customer's **current Excel file or paper process** obtained and examined
- [ ] Scale known: how many assets, rooms, departments, users
- [ ] School type known: public (công lập) or private — this determines whether statutory asset
      regulation applies
- [ ] A first backlog with at least one epic broken into `Ready` stories
- [ ] ADR on the production database engine
- [ ] ADR on the role/permission model

Rushing into sprint 1 on unknown requirements produces a system that has to be rebuilt. One
discovery session is cheaper than one rebuilt sprint.

---

## 4. The flow of one story

```
Draft ──▶ Ready ──▶ In Sprint ──▶ In Progress ──▶ In Review ──▶ Done
```

1. **Draft** — captured from the customer, not yet complete.
2. **Ready** — passes the Definition of Ready. Only Ready stories may enter a sprint.
3. **In Sprint** — committed in `goal.md`, tracked on `board.md`.
4. **In Progress** —
   - `laravel-architect` designs it, if it touches schema or crosses modules
   - branch `feature/AM-###-slug` is created
   - `backend-engineer` and/or `livewire-ui-engineer` implement it
   - `qa-engineer` writes tests against the acceptance criteria
5. **In Review** — `code-reviewer` on the diff; `security-auditor` too if auth, permissions,
   upload or import were touched. Findings are fixed, not argued away.
6. **Done** — `/dod-check` passes. The Scrum Master marks it, not the implementer.

A story that turns out to be bigger than believed is **split**, and the customer is told. It is
never silently carried at 90%.

---

## 5. Scope changes mid-sprint

The customer may change their mind — that is the point of Agile. The mechanism:

- New request → a backlog item with an ID. Never absorbed silently into an in-flight story.
- If it must happen this sprint, something of equal size comes out, and the customer chooses what.
- The sprint goal is not changed mid-sprint. If the goal is genuinely wrong, the sprint is
  cancelled and replanned — that is a real, legitimate option, used rarely and openly.

---

## 6. Rules the delivery lead does not break

1. **Never invent a business rule.** Ask, or mark it `@assumption` and say so out loud.
2. **Report status honestly**, including slippage, on the day it is known.
3. **No story starts without Ready; none finishes without Done.**
4. **Every sprint produces something demoable.** A sprint of pure refactoring is a planning failure.
5. **Tests and review are part of the story**, never a separate later ticket.
6. **The customer decides priority.** The team decides estimates and technical approach.
7. **Never commit or push without being asked.**
