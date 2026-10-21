# Glossary

The shared vocabulary. **The customer's word wins**: the Vietnamese column is what the interface
says (`lang/vi/`), and we do not rename it to something we find tidier.

Rules:
- Every term the customer uses gets an entry, in their words, on the day they use it.
- One concept, one term. Two words for the same thing is how a data model splits in half.
- The `Code` column is the identifier used in PHP, tables and routes. It never changes once code
  exists — rename in the UI instead.

---

## Terms

| Vietnamese (UI) | English | Code | Meaning |
| --- | --- | --- | --- |
| Khối / Lớp 6–9 | Grade | `grade` | THCS grade 6, 7, 8 or 9. A student sees only the units of their own grade. |
| Lớp học | Class | `classroom` | A teacher's group of students; the teacher creates the student accounts in it. `Classroom`, not "class", because `class` is a PHP keyword. |
| Unit | Unit | `curriculum_unit` | One unit of the Global Success syllabus for a grade and term. We store its structure only, never the book's content (ADR-0005). |
| Học kỳ | Term | `term` | School term 1 or 2; groups the units of a grade. |
| Nội dung trọng tâm | Unit focus | `focus` | The vocabulary and grammar point the class is learning in a unit. Every generated exercise is restricted to it. |
| Từ vựng | Unit vocabulary | `unit_vocabulary` | One word of the unit focus, with part of speech and Vietnamese meaning. |
| Ngữ pháp trọng tâm | Grammar focus | `grammar_en` / `grammar_vi` | The grammar point of the unit, in both languages. |
| — (no UI label) | Focus approved | `focus_approved` | Set only when a teacher saves the focus. An AI suggestion alone never sets it. |
| Chủ đề | Topic | `topic` | A communication topic (greetings, shopping…) with sentence patterns and role-play situations. Either a starter topic or one drafted for a unit. |
| Mẫu câu | Sentence pattern | `sentence_pattern` | An English sentence with its Vietnamese meaning, learned within a topic. |
| Mức hỗ trợ: Đầy đủ / Gợi ý / Chỉ tiếng Anh | Support level | `SupportLevel`: `full` / `partial` / `english` | How much Vietnamese the student sees while studying patterns. Support is meant to fade. |
| Tình huống | Role-play scenario | `roleplay_scenario` | A situation the student acts out with the AI partner. |
| Nhập vai | Role-play / conversation | `conversation` | One role-play session between a student and the AI. This is the **speaking** skill. |
| Gợi ý cho em | Hint | — | A suggested next sentence during a role-play. Not stored. |
| Nhận xét của AI | Role-play review | `roleplay_review` | The AI's marking of the student's sentences after a role-play: correction plus a Vietnamese explanation. |
| Nghe / Nói / Đọc / Viết | Skill | `SkillType`: `listening` / `speaking` / `reading` / `writing` | The four skills. Speaking is the role-play; the other three are exercises. |
| Bài luyện | Skill exercise | `skill_exercise` | A reading, listening or writing exercise for a unit. A draft until a teacher publishes it. |
| Bản nháp / Đã phát hành | Draft / Published | `TopicStatus`: `draft` / `published` | Only published content is visible to students. |
| Lần làm | Exercise attempt | `exercise_attempt` | One submission of an exercise by a student. Never edited afterwards. |

## Terms we have deliberately rejected

Record here any term that was considered and dropped, and why — it stops it reappearing in three
months.

| Term | Why rejected | Use instead |
| --- | --- | --- |
| "User" (in stories) | Too vague; hides which role and which data scope | The specific persona |
| "Câu lệnh" as "classroom instructions" | The customer confirmed it means everyday communicative sentences (discovery Session 6) | Sentence pattern |
| "Lesson from the book" | We never reproduce the book's content (ADR-0005) | Unit, unit focus, skill exercise |
