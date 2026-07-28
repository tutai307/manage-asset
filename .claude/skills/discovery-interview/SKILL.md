---
name: discovery-interview
description: How to run a requirements conversation with the customer as a single point of contact — elicitation technique, a question bank for school asset management, how to record answers, and how to close discovery. Load at the start of the project, before each new epic, and whenever the customer describes a need in vague terms.
---

# Discovery interview

You are the customer's single point of contact. Discovery is a **conversation**, not a form. The
output is written requirements the team can build from.

Speak Vietnamese with the customer. Write everything down in English under `docs/product/`.

---

## The rules of the conversation

1. **Ask few questions at a time.** Three to five per turn, maximum. A wall of twenty questions
   gets three answered badly. Prioritise the ones that unblock the most work.
2. **Ask about the present, not the wish.** "How do you do this today?" beats "What do you want?".
   Customers describe solutions; you need the problem underneath.
3. **Ask for artefacts, not descriptions.** The current Excel file, a photo of an asset label, a
   blank statutory form, last year's inventory report. One real artefact is worth an hour of
   questions.
4. **Repeat back before building.** Summarise what you understood in the customer's own words and
   get an explicit yes. Misunderstandings are cheap now and expensive in sprint 4.
5. **Chase the exception.** Every process has one. "What happens when the asset is broken but the
   warranty vendor has gone out of business?" is where the real complexity lives.
6. **Record who decides.** For any rule involving approval or money, find out which named role has
   authority. That role becomes a Policy.
7. **Never fill a gap with a guess.** If you must proceed, write `@assumption:` and say it out loud
   to the customer in your reply.
8. **Timebox.** Discovery that never ends is a failure mode. Get enough to start sprint 1 on a thin
   slice, then keep discovering alongside delivery — that is the point of Agile.

---

## Session 0 — the questions that shape everything

Ask these first. Their answers change the architecture, so they cannot wait.

1. **Scale.** How many assets, roughly? How many rooms, departments, staff who will log in?
   *(100 assets and 20,000 assets are different systems.)*
2. **School type.** Public (công lập) or private/international? *(Determines whether statutory
   asset regulation applies at all.)*
3. **Today's process.** What are you using now — Excel, paper, another system? Can I see it?
4. **The pain.** What goes wrong today that made you want this? What is the single worst moment in
   your current process?
5. **Success.** In six months, what has to be true for you to say this was worth it?
6. **The users.** Who logs in, and what does each of them actually do in a normal week?
7. **The first release.** If we could only ship one thing in six weeks, what would make your life
   better immediately?

---

## Question bank by area

Draw from these as each epic comes up. Do not fire them all at once.

**Asset identity**
- What does an asset code look like today? Can I see three real examples?
- Who assigns the code — the system, or a person?
- Do you have assets bought before this system that need importing?
- Are identical items tracked individually or as a quantity? Why?
- Do you print labels? Barcode, QR code, or handwritten?

**Structure**
- List of buildings, floors, rooms. Does a room belong to a department?
- List of departments/tổ bộ môn and their heads.
- What asset categories do you use? Is the list fixed or does it grow?

**Movement**
- When an asset moves between rooms, what happens today? Who approves it? Is there paperwork?
- Can a teacher borrow an asset temporarily? Is there a return date?
- What happens when a teacher leaves the school and holds assets?

**Condition & maintenance**
- How does someone report a broken item today?
- Who repairs it — internal staff or an external vendor? Do you track repair cost?
- Does an item under repair stay assigned to its room?

**Inventory (kiểm kê)**
- How often, and who does it? Is there a committee?
- Walk me through the last one, step by step.
- What happens when the count does not match the register — surplus and missing?
- Would you do it on a phone in the room, or on paper then type it in?

**Money**
- Do you record purchase value? Who needs to see it?
- Do you need depreciation/hao mòn calculated, or does the accountant do that elsewhere?
- Does this system need to talk to your accounting software?

**Disposal**
- What triggers a thanh lý? Who signs off?
- Does the system need to produce the decision document, or just record it?
- After disposal, must the record remain visible? For how long?

**Reporting**
- Which reports do you produce today, for whom, how often? Can I see the actual forms?
- What is the report someone asks you for that takes you longest to produce?

**Constraints**
- Where will this run — school server, cloud, a PC in the office?
- Internet reliability? Does anything need to work offline?
- Deadline driven by anything real (a school year, an audit, an inspection)?
- Who maintains it after we finish?

---

## Recording the answers

Every session updates:
- `docs/product/vision.md` — problem, users, success measures, scope boundaries
- `docs/product/glossary.md` — every new term the customer used, with their definition
- `docs/product/personas.md` — each user type and their real weekly workflow
- `docs/product/backlog.md` — new candidate items, status `Draft`

Append a dated log entry to `docs/product/discovery-log.md`:

```markdown
## 2026-08-05 — Session 2: inventory process

**Asked about:** kiểm kê workflow, committee, discrepancy handling
**Learned:**
- Counts happen twice a year: end of December and end of the school year in May
- A 3-person committee signs the result; the accountant is always one of them
**Decided:** mobile counting is in scope for v1 — it is the customer's top pain
**Open:** what form does the signed result take? Customer will send the template
**Assumptions made:** none
```

---

## Closing discovery for an epic

You have enough when you can answer, without guessing:
- Who does this, and who must not be able to?
- What are the exact steps, including the exception path?
- What data is captured at each step?
- How do we know it worked — what does the customer check?

Then hand off to `product-owner` to write the stories. If you still cannot answer one of those four,
say which one and ask that specific question instead of starting to build.
