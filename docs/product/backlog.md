# Product backlog

Ordered by value and risk, **not** by ID. IDs are permanent and never reused.

`AM-E##` epic · `AM-###` story · `AM-B##` bug · `AM-T##` technical enabler / spike

Statuses: `Draft` (captured, incomplete) · `Ready` (passes the Definition of Ready) ·
`In Sprint` · `Done` · `Parked`

Product: AI-assisted bilingual communicative English trainer for THCS students — see
[vision.md](vision.md).

---

## Ordered backlog

| # | ID | Title | Type | Priority | SP | Status |
| --- | --- | --- | --- | --- | --- | --- |
| 1 | AM-T01 | Spike: OpenRouter integration and model choice | Enabler | Must | 3 | Done |
| 2 | AM-001 | Sign in as teacher or student | Story | Must | 3 | In Sprint |
| 3 | AM-002 | Teacher creates a class and student accounts | Story | Must | 3 | In Sprint |
| 4 | AM-003 | Starter communication topics with sentence patterns | Story | Must | 3 | In Sprint |
| 5 | AM-004 | Learn a topic's sentences with fading Vietnamese support | Story | Must | 5 | In Sprint |
| 6 | AM-005 | Role-play a text conversation with AI on a topic | Story | Must | 5 | In Sprint |
| 7 | AM-014 | Switch the interface between Vietnamese and English | Story | Must | 3 | In Sprint |
| 8 | AM-015 | Dashboard, sidebar navigation and conversation history | Story | Must | 5 | In Sprint |
| 9 | AM-T02 | Spike: browser speech recognition for student English | Enabler | Must | 2 | Done — answered inside AM-006 |
| 10 | AM-006 | Speak in the role-play instead of typing | Story | Must | 5 | In Sprint 2 |
| 11 | AM-007 | Feedback on the student's sentences after a role-play | Story | Must | 5 | In Sprint 2 |
| 12 | AM-008 | Ask for a Vietnamese hint during the role-play | Story | Should | 2 | In Sprint 2 |
| 13 | AM-016 | Syllabus structure: grades 6–9, 48 units, content per grade | Story | Must | 5 | In Sprint 2 |
| 14 | AM-017 | AI drafts a lesson pack for a syllabus unit, teacher publishes | Story | Must | 5 | In Sprint 2 |
| 15 | AM-022 | Unit vocabulary and grammar, entered or approved by the teacher | Story | Must | 5 | In Sprint 3 |
| 16 | AM-018 | Reading practice per unit | Story | Must | 8 | In Sprint 3 |
| 17 | AM-019 | Listening practice per unit | Story | Must | 8 | In Sprint 3 |
| 18 | AM-020 | Writing practice per unit, marked by AI | Story | Must | 8 | In Sprint 3 |
| 19 | AM-023 | Ship ready-made lessons for all 48 units; teachers edit them | Story | Must | 8 | In Sprint 3 |
| 20 | AM-021 | Unit test, review test and term exam | Story | Must | 13 → split | Draft |
| 21 | AM-013 | Pre/post communication test for the trial | Story | Must | 5 | Draft |
| 22 | AM-012 | Teacher sees which sentences the class struggles with | Story | Should | 5 | Draft |
| 23 | AM-009 | AI drafts a new topic pack from a topic name | Story | Should | 5 | Done — inside AM-017 |
| 24 | AM-010 | Teacher edits and approves a topic before students see it | Story | Should | 3 | Draft |
| 25 | AM-011 | Spaced-repetition review of sentences | Story | Could | 5 | Draft |
| 26 | AM-B01 | Speaker buttons silent where the browser voice never starts | Bug | Must | 2 | Done |
| 27 | AM-024 | Choose a cartoon companion for the role-play | Story | Should | 3 | In Sprint 3 |
| 28 | AM-025 | Role-play as a hands-free video call with the companion | Story | Should | 8 | In Sprint 3 |
| 29 | AM-026 | More question types and vocabulary & grammar exercises | Story | Must | 5 | In Sprint 3 |
| 30 | AM-027 | A teacher writes their own exercise | Story | Must | 3 | In Sprint 3 |
| 31 | AM-028 | Assign an exercise to a class with a due date | Story | Must | 5 | In Sprint 3 |
| 32 | AM-029 | Read a photographed or PDF test into an exercise | Story | Must | 8 | In Sprint 3 |
| 33 | AM-030 | Change my own password | Story | Must | 2 | In Sprint 3 |
| 34 | AM-031 | Administrator resets a teacher's password | Story | Must | 2 | In Sprint 3 |
| 35 | AM-032 | Separate sign-in pages for students and for staff | Story | Must | 2 | In Sprint 3 |
| 36 | AM-033 | Public landing page introducing the product | Story | Must | 3 | In Sprint 3 |
| 37 | AM-034 | Public user guide inside the site | Story | Must | 3 | In Sprint 3 |

---

## Epics

| ID | Epic | Items |
| --- | --- | --- |
| AM-E01 | Accounts and classes | AM-001, AM-002, AM-030, AM-031, AM-032 |
| AM-E02 | Topics and sentence learning | AM-003, AM-004, AM-B01 |
| AM-E03 | AI conversation practice | AM-T01, AM-005, AM-T02, AM-006, AM-007, AM-008, AM-024, AM-025 |
| AM-E04 | AI content authoring with teacher approval | AM-009, AM-010 |
| AM-E05 | Review and progress | AM-011, AM-012 |
| AM-E06 | Trial and evidence | AM-013 |
| AM-E07 | Syllabus-aligned practice (Global Success 6–9) | AM-016, AM-017, AM-022, AM-018, AM-019, AM-020, AM-023, AM-026, AM-027, AM-028, AM-029 |
| AM-E08 | Tests and exams | AM-021 |
| AM-E09 | Public presence | AM-033, AM-034 |

---

## Items

### AM-T01 — Spike: OpenRouter integration and model choice

**Epic:** AM-E03 · **Status:** Ready · **Priority:** Must · **SP:** 3

**Question to answer:** which model on OpenRouter gives correct, level-appropriate (A1–A2) English
replies and structured feedback, with the reply shown in under 5 seconds?

**Output:** a thin client in `app/Services` reading `OPENROUTER_API_KEY` through `config/`; a
comparison of 2–3 candidate models on 5 fixed THCS prompts; ADR-0003 recording provider, model and
fallback.

**Done when:** ADR-0003 accepted; the client is covered by a test that fakes the HTTP call; the key
is read only from `.env` and never logged.

---

### AM-001 — Sign in as teacher or student

**Epic:** AM-E01 · **Status:** Ready · **Priority:** Must · **SP:** 3

**As a** student
**I want to** sign in with the account my teacher gave me
**So that** my practice and progress are kept and only my teacher can see them

**Acceptance criteria**

```gherkin
Scenario: Student signs in
  Given a student account "hs.nguyenvanan" exists in class "7A"
  When I sign in with the correct password
  Then I see my student home page with the topics of class "7A"

Scenario: Wrong password is refused
  Given a student account "hs.nguyenvanan" exists
  When I sign in with a wrong password
  Then I stay on the sign-in page with the message "Tên đăng nhập hoặc mật khẩu không đúng"
  And after 5 failed attempts in one minute further attempts are throttled

Scenario: A student cannot open teacher pages
  Given I am signed in as a student
  When I open the class management page directly
  Then I receive a 403 response
```

**Permissions**
- administrator: creates teacher accounts
- teacher: teacher pages
- student: student pages only

**Data:** reads `users` (role: admin / teacher / student). Reversible: n/a.

**Out of scope:** self-registration; password reset by email (students may have no email).

---

### AM-002 — Teacher creates a class and student accounts

**Epic:** AM-E01 · **Status:** Ready · **Priority:** Must · **SP:** 3

**As a** teacher
**I want to** create a class and add student accounts to it
**So that** my students can start practising without needing an email address

**Acceptance criteria**

```gherkin
Scenario: Create a class with students
  Given I am signed in as teacher "Trần Thị Hoa"
  When I create class "7A" and add students "Nguyễn Văn An" and "Lê Thị Bình"
  Then class "7A" lists both students
  And each student has a generated username and an initial password I can print

Scenario: Duplicate class name for the same teacher is refused
  Given I already have a class "7A"
  When I create another class "7A"
  Then I see "Lớp này đã tồn tại" and no class is created

Scenario: A teacher cannot see another teacher's class
  Given class "8B" belongs to another teacher
  When I open class "8B" directly
  Then I receive a 403 response
```

**Permissions:** teacher: own classes only · student: no · administrator: all

**Data:** writes `classrooms`, `users`, `classroom_user`. Removed students are soft-deleted.

**Out of scope:** Excel import of student lists (later, if the trial needs it).

**@assumption:** no public self-registration — the teacher creates accounts. Shown to the customer.

---

### AM-003 — Starter communication topics with sentence patterns

**Epic:** AM-E02 · **Status:** Ready · **Priority:** Must · **SP:** 3

**As a** teacher
**I want** a ready set of everyday communication topics with bilingual sentence patterns
**So that** the trial can start immediately, before AI authoring exists

**Context**
No textbook is used. Starter topics (`@assumption`, teacher to review):
Greetings & introductions · Family · School & classroom · Daily routines · Hobbies & free time ·
Food & ordering · Shopping · Asking for & giving directions · Weather · Health & at the doctor ·
Making plans & invitations · On the phone.
Each topic: 8–12 sentence patterns (English, Vietnamese meaning, example exchange) and 2 role-play
scenarios, checked for A1–A2 level.

**Acceptance criteria**

```gherkin
Scenario: Topics are available after seeding
  Given the starter content is seeded
  Then 12 published topics exist
  And topic "Shopping" has at least 8 sentence patterns, including "How much is this?" — "Cái này giá bao nhiêu?"

Scenario: Unpublished topics are hidden from students
  Given a topic has status "draft"
  When a student lists topics
  Then that topic is not shown

Scenario: Students cannot change topics
  Given I am signed in as a student
  When I send a request to update a topic
  Then I receive a 403 response
```

**Data:** writes `topics`, `sentence_patterns`, `roleplay_scenarios` via an idempotent seeder.

---

### AM-004 — Learn a topic's sentences with fading Vietnamese support

**Epic:** AM-E02 · **Status:** Ready · **Priority:** Must · **SP:** 5 · **Depends on:** AM-001, AM-003

**As a** student
**I want to** study a topic's sentences, hear them spoken, and reduce the Vietnamese help as I improve
**So that** I can understand and say them without relying on translation

**Acceptance criteria**

```gherkin
Scenario: Full support level
  Given I open topic "Shopping" at support level "Đầy đủ"
  Then each sentence shows English and Vietnamese
  And pressing the speaker icon reads the English sentence aloud

Scenario: English-only level
  Given I switch to support level "Chỉ tiếng Anh"
  Then Vietnamese is hidden
  And I can reveal the Vietnamese of one sentence by clicking "Xem nghĩa"
  And that reveal is recorded against my progress

Scenario: Draft topics cannot be opened by students
  Given topic "Weather" is a draft
  When I open its URL directly as a student
  Then I receive a 404 response
```

**Permissions:** student: published topics only · teacher: all topics

**Data:** writes `pattern_reveals` (student, pattern, time). Append-only.

**Out of scope:** pronunciation scoring; spaced repetition (AM-011).

---

### AM-005 — Role-play a text conversation with AI on a topic

**Epic:** AM-E03 · **Status:** Ready · **Priority:** Must · **SP:** 5 · **Depends on:** AM-T01, AM-003

**As a** student
**I want to** have a short typed conversation with an AI playing a role in a real situation
**So that** I practise using the sentences, not just reading them

**Acceptance criteria**

```gherkin
Scenario: Conversation in a situation
  Given topic "Shopping" has scenario "Buying a T-shirt" where the AI is the shop assistant
  When I start the role-play
  Then the AI greets me in simple English in its role
  And when I type "How much is this T-shirt?" the AI replies in role within 5 seconds

Scenario: Off-topic or unsafe input is redirected
  Given I am in the role-play
  When I type something unrelated or inappropriate
  Then the AI politely steers back to the shopping situation in English
  And no unsafe content is shown

Scenario: The AI is unavailable
  Given the AI provider returns an error
  When I send a message
  Then I see "Trợ lý đang bận, em thử lại sau nhé" and my typed message is kept

Scenario: A student cannot read another student's conversation
  Given a conversation belongs to another student
  When I open it directly
  Then I receive a 403 response
```

**Data:** writes `conversations`, `conversation_messages`. No student name is sent to the AI.

**Out of scope:** voice (AM-006), feedback (AM-007), hints (AM-008). Maximum 12 turns per session.

---

### AM-014 — Switch the interface between Vietnamese and English

**Epic:** AM-E01 · **Status:** In Sprint · **Priority:** Must · **SP:** 3

**As a** student or teacher
**I want to** choose Vietnamese or English for the whole interface
**So that** the screens are not a confusing mix of both languages

**Context:** requested by the customer on 2026-09-18 after seeing mixed-language screens. Learning
content (English sentence + Vietnamese meaning) stays bilingual in both modes by design.

```gherkin
Scenario: Switch to English
  Given I am on the sign-in page in Vietnamese
  When I press "EN"
  Then the page shows "Sign in" and no Vietnamese interface text

Scenario: English mode shows English topic and scenario descriptions
  Given my interface language is English
  When I open topic "Shopping"
  Then I see "Ask about prices, sizes and colours, and buy things in a shop."
  And I do not see "Hỏi giá, hỏi cỡ và màu sắc"

Scenario: Unsupported language is refused
  When a request switches the language to "fr"
  Then it receives a 404 response and the language is unchanged

Scenario: Choice is remembered per account
  Given I switched to English while signed in
  When I sign in again on another computer
  Then the interface is in English
```

**Permissions:** everyone, including guests (session only).
**Data:** writes `users.locale`; adds `topics.description_en`, `roleplay_scenarios.situation_en`.

---

### AM-015 — Dashboard, sidebar navigation and conversation history

**Epic:** AM-E05 · **Status:** In Sprint · **Priority:** Must · **SP:** 5

**As a** student or teacher
**I want** a home page that shows where I am, and a menu that shows everything I can reach
**So that** I can find my way around without being told where to click

**Context:** requested by the customer on 2026-09-20 — the first screens had no navigation and the
visual design was over-decorated. The second pass drops gradients and per-item cards, uses one
accent colour, and reserves semantic colour for state.

```gherkin
Scenario: Student home
  Given I am a student who has practised one role-play
  When I open the home page
  Then I see my progress figures, my recent conversations, and suggested topics

Scenario: Teacher home is scoped to their classes
  Given another teacher's class "8B" has active students
  When I open the home page as the teacher of class "7A"
  Then I see my own class and students
  And I do not see class "8B" or its students

Scenario: Conversation history is private
  Given another student has a conversation
  When I open my conversation list
  Then only my own conversations are listed

Scenario: Guests are refused
  When a signed-out visitor opens the home page
  Then they are redirected to the sign-in page
```

**Data:** adds `topics.emoji`, `config('app.display_timezone')`. Reads only; no new writes.

---

### AM-006 — Speak in the role-play instead of typing

**Epic:** AM-E03 · **Status:** In Sprint 2 · **Priority:** Must · **SP:** 5

**As a** student
**I want to** say my answer out loud instead of typing it
**So that** I practise speaking, which is the point of the product

**Context:** the AM-T02 question — can the browser do this? — was answered by building it: Chrome and
Edge expose `SpeechRecognition`; Firefox and Safari do not. The microphone button is therefore
feature-detected and typing always remains available.

```gherkin
Scenario: Dictating an answer
  Given I am in a role-play in Chrome
  When I press the microphone button and say "How much is this T-shirt?"
  Then that sentence appears in the message box
  And I can edit it before sending

Scenario: A browser without speech recognition
  Given my browser has no speech recognition
  When I open the role-play
  Then no microphone button is shown and typing still works

Scenario: Microphone permission refused
  When the browser refuses microphone access
  Then I see "Trình duyệt chưa được cấp quyền dùng micro." and can still type
```

**Data:** none — recognition happens in the browser; only the final sentence is sent as a message.

**Not covered by automated tests:** the recognition itself is browser API code. Tested by hand.

---

### AM-007 — Feedback on the student's sentences after a role-play

**Epic:** AM-E03 · **Status:** In Sprint 2 · **Priority:** Must · **SP:** 5

**As a** student
**I want** the AI to mark the sentences I wrote and show better versions
**So that** I learn from my mistakes instead of repeating them

```gherkin
Scenario: Marked sentences
  Given I have written at least 2 sentences in a role-play
  When I ask for feedback
  Then each sentence is marked good or improvable
  And an improvable sentence shows a better English version and a Vietnamese explanation
  And a short summary says what to work on

Scenario: Too short to mark
  Given I have written 1 sentence
  When I ask for feedback
  Then I see "Em cần nói ít nhất 2 câu…" and no AI request is made

Scenario: The AI answer cannot be read
  Given the provider returns something that is not the expected JSON
  Then I see a retry message and nothing is stored

Scenario: Another student's conversation
  When I open someone else's conversation
  Then I receive a 403 response and no review can be requested
```

**Data:** writes `roleplay_reviews` and `roleplay_review_items`, both append-only; the latest review
is displayed. No student name is sent to the provider.

---

### AM-008 — Ask for a Vietnamese hint during the role-play

**Epic:** AM-E03 · **Status:** In Sprint 2 · **Priority:** Should · **SP:** 2

**As a** student
**I want** one suggested sentence when I am stuck
**So that** the conversation does not stop when I run out of words

```gherkin
Scenario: Getting a hint
  Given the partner has just asked me something
  When I press "Gợi ý cho em"
  Then I see one short English sentence with its Vietnamese meaning
  And I can put it in the message box or listen to it

Scenario: The assistant is unavailable
  Then I see the busy message and no hint is shown
```

**Data:** none — the hint is transient and not stored. `@assumption` the teacher does not need to
know how often hints were used; revisit with AM-012.

---

### AM-B01 — Speaker buttons silent where the browser voice never starts

**Epic:** AM-E02 · **Status:** Done · **Priority:** Must · **SP:** 2 · **Found:** 2026-10-21 by the customer

**Symptom:** pressing any speaker button (sentences, vocabulary, role-play, listening) plays
nothing in Chrome or Edge on the customer's Windows machine.

**Cause:** Chromium accepts `speechSynthesis.speak()` but never starts or reports an error, even on
a blank page. Windows' voices and Chrome's normal audio both work, so the app cannot repair the
browser.

**Fix:** if the browser voice has not started within 1.5 s, the page uses an in-page Piper voice
instead ([ADR-0006](../architecture/adr/0006-in-page-voice-fallback.md)). The first use downloads
the voice once, and the toast says so.

**Done when:** a speaker press is audible in Chrome and Edge on the customer's machine; Stop
silences both voices; `SkillExerciseTest` guards the view wiring.

---

### AM-024 — Choose a cartoon companion for the role-play

**Epic:** AM-E03 · **Status:** In Sprint 3 · **Priority:** Should · **SP:** 3 · **Source:** discovery Session 16

As a student, I choose a cartoon companion (Miu, Robo, Dino or Oli) so that practising English feels
like talking with a friend.

```gherkin
Scenario: first call asks for a companion
  Given I have never chosen a companion
  When I open a role-play
  Then I see the four companions and must pick one before the call starts

Scenario: the choice is remembered and can be changed
  Given I chose Robo earlier
  When I open a new role-play
  Then Robo is ready to call, and I can switch to another companion before starting

Scenario: the companion's personality shapes the reply, not the student's data
  Given I chose Oli
  When I send a message
  Then the AI request contains Oli's personality and the scenario role
  And it contains neither my name nor my username
```

**Data:** `users.companion` (the student's choice) and `conversations.companion` (who played that
conversation). Both nullable; values from `App\Enums\Companion`.

---

### AM-025 — Role-play as a hands-free video call with the companion

**Epic:** AM-E03 · **Status:** In Sprint 3 · **Priority:** Should · **SP:** 8 · **Source:** discovery Session 16

As a student, I talk with my companion in an animated video call, so that I practise speaking
without typing.

```gherkin
Scenario: the companion speaks and then listens
  Given I started the call
  When the companion says its line in its own voice
  Then its mouth moves with the sound
  And when it finishes, the microphone opens by itself

Scenario: what I say is sent when I stop speaking
  Given the companion is listening
  When I say a sentence and stop
  Then the sentence is sent, the companion shows it is thinking, and then it answers

Scenario: subtitles can be hidden
  When I press the subtitle button
  Then the companion's line is hidden, and pressing again shows it

Scenario: browser without speech recognition
  Given my browser cannot recognise speech
  Then the call still works with the typing box, and the companion still speaks its answers
```

**Not in scope:** a real camera, a voice picker separate from the character, teachers changing
characters.

---

### AM-026 — More question types and vocabulary & grammar exercises

**Epic:** AM-E07 · **Status:** In Sprint 3 · **Priority:** Must · **SP:** 5 · **Source:** discovery Session 17

As a teacher, I use the question types of my own tests: put words in order, rewrite a sentence,
matching, and pronunciation or stress, in a "Vocabulary & grammar" exercise.

```gherkin
Scenario: each type is marked automatically
  Given an exercise with reorder, rewrite, matching and pronunciation questions
  When a student hands it in
  Then each answer is marked, and a rewrite accepts every wording the teacher listed

Scenario: a reorder answer must use the given words
  When I save a reorder question whose answer uses other words
  Then the editor refuses it
```

---

### AM-027 — A teacher writes their own exercise

**Epic:** AM-E07 · **Status:** In Sprint 3 · **Priority:** Must · **SP:** 3 · **Source:** discovery Session 17

As a teacher, I create an exercise myself, for a unit or just a grade, without asking the AI.

```gherkin
Scenario: my exercise is mine
  Given I created an exercise
  Then other teachers and students cannot open it until I assign it
  And it does not appear in the unit's open practice
```

---

### AM-028 — Assign an exercise to a class with a due date

**Epic:** AM-E07 · **Status:** In Sprint 3 · **Priority:** Must · **SP:** 5 · **Source:** discovery Session 17

As a teacher, I give an exercise to one or more of my classes with an optional due date, and see
who has done it and how well.

```gherkin
Scenario: students see what is assigned
  Given I assigned an exercise to 7A due Friday 21:00
  Then students of 7A see it under "Assigned to me" and on their dashboard
  And students of other classes cannot open it

Scenario: results
  When I open the assignment
  Then I see each student's best score, attempts, last attempt and whether they were late

Scenario: an unchecked upload cannot be assigned
  Given the exercise still has questions marked "Check this"
  Then assigning is refused until I have saved it
```

---

### AM-029 — Read a photographed or PDF test into an exercise

**Epic:** AM-E07 · **Status:** In Sprint 3 · **Priority:** Must · **SP:** 8 · **Source:** discovery Session 17

As a teacher, I upload photos or a PDF of a test I wrote, and get an exercise to check and assign.
Design: [ADR-0007](../architecture/adr/0007-teacher-exercises-uploads-and-assignments.md).

```gherkin
Scenario: the AI transcribes my test
  Given I upload my own test and confirm it is mine and blank
  Then a draft exercise holds my questions in my order
  And questions the AI was unsure of are marked "Check this"
  And parts it could not convert are listed
  And the original is shown beside the editor

Scenario: confirmations
  When I do not confirm that the test is my own and has no student details
  Then nothing is sent to the AI

Scenario: privacy
  Then the photo is re-encoded without its metadata
  And the AI request contains neither my name nor any student's
```

**Not in scope:** Word files; textbook pages (refused by the customer, ADR-0005).

---

### AM-030 — Change my own password

**Epic:** AM-E01 · **Status:** In Sprint 3 · **Priority:** Must · **SP:** 2 · **Source:** discovery Session 19

As a student, I change the password my teacher gave me to one only I know.

```gherkin
Scenario: change it
  Given I am signed in
  When I give my current password and a new one twice
  Then the new password works and the old one does not

Scenario: refused
  When my current password is wrong, the new one is under 8 characters,
    the two new ones differ, or the new one equals the current one
  Then I see why in my language and my password stays as it was
```

**@assumption:** teachers and administrators can use the same page for their own password. Minimum
length is 8, the length of generated passwords. Shown to the customer.

---

### AM-031 — Administrator resets a teacher's password

**Epic:** AM-E01 · **Status:** In Sprint 3 · **Priority:** Must · **SP:** 2 · **Source:** discovery Session 19

As an administrator, I give a teacher a new password when they need one.

```gherkin
Scenario: reset
  Given I am an administrator on the teacher list
  When I reset a teacher's password and confirm
  Then a new random password is shown to me once and the old one stops working

Scenario: only teachers, only by administrators
  Then a teacher or student cannot open the list
  And the list cannot reset a student's or another administrator's password
```

**@assumption:** the system generates the new password, as it does for students, rather than the
administrator typing one. Shown to the customer.

---

### AM-032 — Separate sign-in pages for students and for staff

**Epic:** AM-E01 · **Status:** In Sprint 3 · **Priority:** Must · **SP:** 2 · **Source:** discovery Session 19

As a student or a member of staff, I sign in on the page meant for me.

```gherkin
Scenario: students on /login, staff on /staff/login
  Then each page accepts only its own roles
  And an account from the other page gets the same message as a wrong password
  And each page links to the other

Scenario: signing out
  Then I return to the sign-in page for my role
```

**@assumption:** a guest opening a protected page is sent to the student page, which links to the
staff page. Shown to the customer.

---

### AM-033 — Public landing page introducing the product

**Epic:** AM-E09 · **Status:** In Sprint 3 · **Priority:** Must · **SP:** 3 · **Source:** discovery Session 20

As a visitor, such as a jury member, a teacher or a parent, I see what English Buddy is without an
account, so that I understand it and know where to sign in.

```gherkin
Scenario: a guest opens the site
  When a signed-out visitor opens "/"
  Then they see the introduction, links to both sign-in pages and a link to the user guide

Scenario: a signed-in user opens the site
  When a signed-in user opens "/"
  Then they are redirected to their dashboard, now at "/dashboard"

Scenario: both languages
  When the visitor switches to English
  Then the page is in English and they stay on it
```

**Data:** none. The page states only facts true of the product; no invented figures or testimonials.

**@assumption:** the landing page takes "/" and the dashboard moves to "/dashboard". The AM-015
guest rule still holds for the dashboard. Shown to the customer.

---

### AM-034 — Public user guide inside the site

**Epic:** AM-E09 · **Status:** In Sprint 3 · **Priority:** Must · **SP:** 3 · **Source:** discovery Session 20

As a student, teacher or administrator, I read how to use the software at a public address, so that
I can find my way without being shown.

```gherkin
Scenario: no account needed
  When anyone opens "/guide"
  Then they can read the guide for students, teachers and administrators

Scenario: easy to find
  Then the guide is linked from the landing page, the sign-in pages and the app menu

Scenario: both languages
  Then every section exists in Vietnamese and English with the same structure
```

**Maintenance:** the text lives in `lang/*/guide.php` and quotes on-screen button names, so a change
to a screen or its label must update the guide too.

**Out of scope:** screenshots in the guide; a guide to installing the software.

---

### Draft items — detailed before their sprint

- **AM-T02** — Verify Chrome/Edge speech recognition on THCS students' English; decide a fallback.
- **AM-006** — As a student, I speak into the microphone instead of typing, so that I practise speaking.
- **AM-007** — As a student, after a role-play I see each of my sentences marked good / could be better, with a better version and a Vietnamese explanation.
- **AM-008** — As a student, I press "Gợi ý" to see what I could say next, in English with its Vietnamese meaning.
- **AM-009** — As a teacher, I type a topic name and AI drafts sentence patterns and scenarios as a draft topic.
- **AM-010** — As a teacher, I edit and publish a draft topic; students see only published topics.
- **AM-011** — As a student, I review sentences I revealed or got wrong, at spaced intervals.
- **AM-012** — As a teacher, I see per class which sentence patterns are most revealed or corrected, and who has not practised.
- **AM-013** — As a teacher, I give the same short communication test before and after the trial and compare class results.

---

## Parked

| ID | Item | Why parked |
| --- | --- | --- |
| — | Electricity/AC usage tracking (discovery Sessions 1–3) | Competition topic changed by the teacher, Session 4 |

---

## Open questions

| # | Question | Blocks | Asked | Answered |
| --- | --- | --- | --- | --- |
| 1 | THCS or THPT — which school and level does the entry represent? | Content level, personas | 2026-09-17 | 2026-10-21 — THCS, grades 6–9 (discovery Session 14) |
| 2 | Does the teacher approve the 12 starter topics? | AM-003 content | 2026-09-17 | — |
