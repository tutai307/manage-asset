---
name: asset-domain
description: Domain reference for school asset management in Vietnam — vocabulary, the asset lifecycle, roles, the entities you will almost certainly need, and the regulatory questions that must be asked rather than assumed. Load before writing requirements, designing the schema, or interviewing the customer about assets, inventory, depreciation or disposal.
---

# Domain: school asset management (Vietnam)

This is a **map of the territory, not a specification**. Nothing here is an agreed requirement.
Everything marked ❓ must be confirmed with the customer before it enters a story.

---

## 1. Canonical vocabulary

Use these terms consistently. The English term is the code identifier; the Vietnamese term is what
the customer says and what appears in the UI.

| English (code) | Vietnamese (UI) | Meaning |
| --- | --- | --- |
| Asset | Tài sản | A single tracked item, individually identified |
| Fixed asset | Tài sản cố định (TSCĐ) | Asset above a value/life threshold, depreciated |
| Consumable / supply | Công cụ dụng cụ, vật tư tiêu hao | Tracked by quantity, not individually |
| Asset code | Mã tài sản | The unique human-readable identifier on the label |
| Asset category | Nhóm / loại tài sản | Classification, usually hierarchical |
| Location / Room | Phòng, địa điểm | Where the asset physically is |
| Department / Unit | Đơn vị, tổ bộ môn, phòng ban | Who is organisationally responsible |
| Custodian | Người quản lý / người chịu trách nhiệm | The person accountable for the asset |
| Acquisition | Mua sắm, tiếp nhận | How the asset entered the register |
| Handover | Bàn giao | Transfer of custody, usually with a signed record |
| Transfer | Điều chuyển | Move between rooms/departments |
| Maintenance / Repair | Bảo trì / sửa chữa | Servicing event with cost and downtime |
| Inventory count | Kiểm kê | Periodic physical verification against the register |
| Depreciation | Khấu hao | Value reduction (typically for revenue-generating use) |
| Wear-and-tear amortisation | Hao mòn | Value reduction used for public-sector assets |
| Disposal / Liquidation | Thanh lý | Removing an asset from service, with a decision record |
| Write-off | Ghi giảm, hủy bỏ | Removing a lost/destroyed asset from the register |
| Decision document | Quyết định | The signed paper that authorises a transfer/disposal |

**Rule:** `hao mòn` and `khấu hao` are different concepts in Vietnamese public accounting. Do not
translate both as "depreciation" in the data model without asking which one this school uses. ❓

---

## 2. The asset lifecycle

```
   Procurement request  ──▶  Acquisition / receipt  ──▶  Registration (code + label)
                                                              │
                                                              ▼
                                                      Allocation to room + custodian
                                                              │
                      ┌───────────────┬───────────────┬───────┴────────┐
                      ▼               ▼               ▼                ▼
                 In use ◀──────▶ Transfer      Maintenance       Inventory count
                      │                              │                │
                      │                              ▼                ▼
                      │                        Out of service    Found / Missing /
                      │                                          Surplus discrepancy
                      ▼
             Disposal / Liquidation / Write-off  ──▶  Archived (never hard-deleted)
```

Each arrow is a **state transition that needs a rule**: who may perform it, what evidence is
required, and whether it can be reversed. Those rules are the heart of the application and they are
exactly what must come from the customer.

---

## 3. Entities you will probably need

Treat this as a checklist for the discovery conversation, not a schema.

**Core**
- `assets` — code, name, category, status, condition, acquisition date, original value, current
  location, custodian, supplier, warranty end, serial number, notes, images
- `asset_categories` — hierarchical (parent_id), possibly mapped to an official category code ❓
- `locations` / `rooms` — building, floor, room number, capacity, responsible department
- `departments` — tổ bộ môn / phòng ban, with a head
- `users` — staff, with roles

**Movement & events** (append-only history — this is what makes the system trustworthy)
- `asset_transfers` — from/to location, from/to custodian, date, reason, decision document
- `asset_maintenances` — type, vendor, cost, start/end date, outcome
- `asset_status_histories` — every status change, who, when, why

**Inventory**
- `inventory_sessions` — period, scope, status (draft/in progress/closed), committee members
- `inventory_items` — expected vs actually found, condition observed, discrepancy note

**Financial** (only if in scope ❓)
- `asset_valuations` / `depreciation_entries` — period, method, amount, accumulated

**Procurement** (frequently out of scope for v1 ❓)
- `procurement_requests`, `purchase_orders`, `suppliers`

**Cross-cutting**
- `activity_log` — who did what to which record. Non-negotiable for a system of record.
- `attachments` — invoices, decision documents, photos

---

## 4. Roles — a typical school shape

Confirm the real names and powers with the customer; do not assume this hierarchy. ❓

| Role | Typical Vietnamese title | Typically can |
| --- | --- | --- |
| System administrator | Quản trị hệ thống | Everything, manage users and reference data |
| Asset manager | Cán bộ quản lý tài sản / kế toán tài sản | Full asset CRUD, transfers, run inventory, reports |
| Department head | Tổ trưởng / trưởng phòng ban | View and request for their own department only |
| Teacher / staff | Giáo viên, nhân viên | View assets they are custodian of, report a fault |
| Accountant | Kế toán | Financial fields, depreciation, valuation reports |
| Principal / Vice-principal | Hiệu trưởng / phó hiệu trưởng | Approve disposals and high-value transfers, read all |
| Auditor | Thanh tra, kiểm tra | Read-only across everything, including history |

**Design consequence:** most permissions are *scoped by department*, not global. A department head
with the "view assets" permission must still only see their own department. Build scoping into the
query layer from day one — bolting it on later means auditing every query.

---

## 5. Regulatory context — questions, not answers

Vietnamese public-sector asset management is regulated. A state school is bound by rules that a
private/international school may not be. **Do not encode any of this until the customer's accountant
confirms it applies.**

Ask, do not assume:
- ❓ Is this a public (công lập) or private/international school? This changes almost everything
  about depreciation, disposal authority and reporting.
- ❓ Which regulation does the school's accounting follow for fixed assets and hao mòn/khấu hao?
  (The customer's accountant will name the current circular — ask them to name it rather than
  guessing on their behalf, as these circulars are revised.)
- ❓ What is the value threshold and minimum useful life for something to count as a TSCĐ?
- ❓ Which official asset classification / category codes must the register use, if any?
- ❓ Must the system produce specific statutory report forms (biểu mẫu) for the education department
  or finance department? Get the actual blank forms — do not design reports from a description.
- ❓ Is there an existing government asset system the data must be exported to or reconciled with?
- ❓ How often is kiểm kê mandated, and who must sit on the committee?
- ❓ What signed paperwork must accompany a transfer or a thanh lý, and does the system need to
  generate it?

**Guidance:** if regulation is in play, design the register to be *correct and complete* first, and
treat statutory report generation as a separate later epic. Getting the underlying data right makes
any report possible; getting a report to look right over bad data helps nobody.

---

## 6. Traps specific to this domain

1. **Asset codes are not database IDs.** They encode meaning (category, year, department) and the
   school already has a format. Ask for real examples of existing labels before designing the
   generator, and support codes that predate the system.
2. **History is the product.** "Where was this projector in March?" is a core question. Never model
   location as a single mutable column with no history table.
3. **Assets are never deleted.** They are disposed, written off, or archived. Every delete path
   should be a status change plus a record of who decided it.
4. **Bulk reality.** Schools receive 40 identical chairs at once and count 500 items in a week.
   Single-record CRUD alone will not survive contact with users — bulk create, bulk transfer and a
   fast count workflow matter, and mobile/barcode scanning for kiểm kê is usually the top request.
5. **Quantity vs identity.** A projector is one tracked asset; 200 chairs may be one record with
   quantity 200, or 200 records. The customer's inventory practice decides this and it is a
   fundamental modelling fork — resolve it early. ❓
6. **The school year, not the calendar year,** is often the reporting period. Confirm the fiscal
   and academic period boundaries. ❓
7. **The existing spreadsheet is the real spec.** Almost every school already tracks assets in
   Excel. Ask for the file. Its columns tell you the true data model and its messiness tells you
   what the import must tolerate.
