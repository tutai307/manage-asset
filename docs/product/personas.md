# Personas

> **Status: hypotheses only.** These are *candidate* roles based on how Vietnamese schools typically
> organise asset management. Every one must be confirmed, renamed, merged or deleted during
> discovery. A role that is not confirmed must not appear in a story or a Policy.

Each confirmed persona becomes: a role in the permission model, a set of Policy rules, and the
`As a …` subject of stories.

---

## Template — copy this for each confirmed role

```markdown
### <Role name> — <Vietnamese title>

**Who:** how many people, what else their job involves
**Technical comfort:** low / medium / high · **Devices:** desktop / phone / both
**Uses the system:** daily / weekly / twice a year

**A normal week:** what they actually do, step by step, in their own words

**Needs:** the 3 things they must be able to do
**Must NOT be able to:** the operations that are dangerous in their hands
**Scope of data:** everything / their own department only / only assets they hold
**Pain today:** the thing that wastes their time now
```

---

## Candidate roles — TO CONFIRM

### System administrator — Quản trị hệ thống
Manages users, roles and reference data. Usually the school's IT staff member. May be the same
person as the asset manager in a small school. ❓

### Asset manager — Cán bộ quản lý tài sản
The primary user. Registers assets, records transfers, runs kiểm kê, produces reports. Most likely
the person who owns the current Excel file. **Interview this person first** — they hold the real
process. ❓

### Accountant — Kế toán
Cares about value, hao mòn/khấu hao, and statutory reports. May want the system to feed their
accounting software, or may want it to stay out of the way. ❓

### Department head — Tổ trưởng bộ môn / Trưởng phòng ban
Responsible for the assets in their unit. Likely read-only plus the ability to request a transfer or
report a fault. Data scoped to their own department — this scoping is the single most important
authorization rule in the system. ❓

### Teacher / staff — Giáo viên, nhân viên
Occasional user. Realistically: sees what they are custodian of, and reports something broken. If
the workflow is heavier than that, they will not use it. ❓

### Principal / Vice-principal — Hiệu trưởng / Phó hiệu trưởng
Approves disposals and significant transfers, reads summary reports. Low frequency, high stakes,
low tolerance for a confusing screen. ❓

### Auditor / inspector — Thanh tra, kiểm tra
Read-only across everything **including history**. May be external. Determines how trustworthy the
audit trail must be. ❓

---

## Questions to resolve for every role

- Does this role exist at this school, under this name?
- Is it one person or many?
- Is their data scope global, department-level, or personal?
- What is the one operation that would be a disaster if they could perform it?
- Will they realistically log in, or will someone do it on their behalf?

The last question decides whether a role is a real user or just a name on a report. Building screens
for a role that never logs in is pure waste.
