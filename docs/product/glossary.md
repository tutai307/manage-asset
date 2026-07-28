# Glossary

The shared vocabulary. **The customer's word wins.** When they call it "phiếu bàn giao", the UI says
"phiếu bàn giao" — we do not rename it to something we find tidier.

Rules:
- Every term the customer uses gets an entry, in their words, on the day they use it.
- One concept, one term. Two words for the same thing is how a data model splits in half.
- The `Code` column is the identifier used in PHP, tables and routes. It never changes once code
  exists — rename in the UI instead.

---

## Confirmed terms

| Vietnamese (UI) | English | Code | Definition (customer's words) |
| --- | --- | --- | --- |
| _TBD_ | | | |

## Provisional terms — from domain knowledge, NOT yet confirmed

These come from the `asset-domain` skill. Confirm each with the customer, then move it up to the
table above. Do not use an unconfirmed term in a story.

| Vietnamese | English | Code | Note |
| --- | --- | --- | --- |
| Tài sản | Asset | `asset` | An individually tracked item |
| Tài sản cố định (TSCĐ) | Fixed asset | `fixed_asset` | ❓ What threshold makes an item a TSCĐ here? |
| Công cụ dụng cụ | Tools & equipment | ❓ | ❓ Tracked individually or by quantity? |
| Mã tài sản | Asset code | `code` | ❓ Need three real examples of the existing format |
| Nhóm tài sản | Asset category | `asset_category` | ❓ Fixed list or does it grow? |
| Phòng | Room / location | `location` | ❓ Is a room owned by a department? |
| Đơn vị / tổ bộ môn | Department | `department` | ❓ What is the correct term at this school? |
| Người quản lý | Custodian | `custodian` | ❓ Is one person accountable per asset? |
| Bàn giao | Handover | `handover` | ❓ Is this different from điều chuyển here? |
| Điều chuyển | Transfer | `transfer` | Move between rooms or departments |
| Bảo trì / sửa chữa | Maintenance / repair | `maintenance` | ❓ One concept or two? |
| Kiểm kê | Inventory count | `inventory_session` | ❓ How often, and who signs it? |
| Hao mòn | Wear-and-tear amortisation | ❓ | ⚠️ Different from khấu hao — confirm which applies |
| Khấu hao | Depreciation | ❓ | ⚠️ See above. Do not merge these two in the data model. |
| Thanh lý | Disposal / liquidation | `disposal` | ❓ Who authorises it? |
| Ghi giảm | Write-off | ❓ | ❓ Used for lost/destroyed assets? |
| Quyết định | Decision document | `decision_ref` | The signed paper authorising an action |
| Biểu mẫu | Statutory form | — | ❓ Which ones must the system produce? |

---

## Terms we have deliberately rejected

Record here any term that was considered and dropped, and why — it stops it reappearing in three
months.

| Term | Why rejected | Use instead |
| --- | --- | --- |
| "User" (in stories) | Too vague; hides which role and which data scope | The specific persona |
| "Depreciation" as a catch-all | Conflates hao mòn and khấu hao, which differ in Vietnamese public accounting | The specific one, once confirmed |
