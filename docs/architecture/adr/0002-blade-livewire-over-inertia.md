# ADR-0002 — Blade + Livewire for the interface, not an SPA

- **Status:** Accepted
- **Date:** 2026-07-29
- **Deciders:** delivery lead, customer
- **Context revised:** 2026-10-21, for the current product. Decision unchanged.

## Context

English Buddy is a school web application: teacher screens (classes, accounts, unit content,
exercise editing) and student screens (studying sentence patterns, exercises, a chat-style role-play
with an AI partner). It is used on computers, at school or at home.

Constraints that shaped the choice:
- PHP 8.2 on XAMPP; the customer's environment is PHP-centric.
- After delivery the system is maintained by people whose skills are much more likely to be PHP than
  modern JavaScript tooling.
- Requirements are discovered sprint by sprint. Whatever we choose must let us change screens
  cheaply, without a build-tooling tax on every change.
- A few interactions are browser-only — text-to-speech and speech recognition — and need a small
  amount of JavaScript regardless of the framework.

## Decision

Blade templates + **Livewire 4** + **Tailwind CSS 4**, served by Laravel. No Inertia, no separate
SPA, no separate frontend build pipeline beyond Vite. Browser speech features are small, isolated
scripts in `resources/js/`, not a reason to adopt a frontend framework.

## Options considered

**A. Blade + Livewire + Tailwind (chosen).** One language, one codebase, one mental model.
Server-side authorization and validation are the natural path rather than something to remember.
Fastest route to a demoable slice each week, which matters when the customer's feedback is our main
tool for reducing requirement risk. Cost: every interaction is a round trip, and Livewire's public
properties are a genuine security footgun that the team must understand.

**B. Inertia + React (or Vue) + Tailwind.** Richer client-side interaction. Rejected: it doubles the
skill surface for maintenance, adds a frontend build to every change, and buys interaction quality
this application does not need. The team would spend sprint 1 on plumbing rather than on the
product.

**C. API-only Laravel + a separate frontend.** Maximum flexibility, and the right answer if a mobile
app were confirmed. Rejected: mobile apps are out of scope, and it would be the most expensive
option to build and hand over.

**D. Plain Blade with no Livewire.** Simplest possible. Rejected: the role-play chat, exercise
forms and filters would each need hand-written JavaScript, which ends up as a worse version of
Livewire.

## Consequences

**Positive:** one language for the whole team; server-side authorization is the default path;
screens can be built and demoed within a single sprint; handover to a PHP-literate maintainer is
realistic.

**Negative:**
- Every interaction is a network round trip, on top of AI replies that take seconds. Screens that
  call the AI must show a working state.
- **Livewire public properties are client-writable.** Every action method must re-authorize
  server-side; a trusted ID held in a public property is a real vulnerability. This is written into
  the `livewire-blade-ui` skill and is a `code-reviewer` blocker.
- The app needs a network connection; offline use would need a new ADR — Livewire cannot do it.
