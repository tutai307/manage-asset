# ADR-0002 — Blade + Livewire for the interface, not an SPA

- **Status:** Accepted
- **Date:** 2026-07-29
- **Deciders:** delivery lead, customer

## Context

`manage-asset` is an internal administrative application for a school: forms, tables, filters,
reports, and an inventory-counting flow. It is not a public product and has no consumer-grade
interaction requirements.

Constraints that shaped the choice:
- PHP 8.2 on XAMPP; the customer's environment is PHP-centric.
- After delivery the system is maintained by the school's IT staff, whose skills are much more
  likely to be PHP than modern JavaScript tooling.
- Requirements are largely unknown. Whatever we choose must let us change screens cheaply, sprint
  by sprint, without a build-tooling tax on every change.
- Inventory counting will probably happen on phones, so the UI must work well on a small screen —
  but that is a responsive-design requirement, not a native-app one.

## Decision

Blade templates + **Livewire 4** + **Tailwind CSS 4**, served by Laravel. No Inertia, no separate
SPA, no separate frontend build pipeline beyond Vite for assets.

## Options considered

**A. Blade + Livewire + Tailwind (chosen).** One language, one codebase, one mental model.
Server-side authorization and validation are the natural path rather than something to remember.
Fastest route to a demoable slice each week, which matters when the customer's feedback is our main
tool for reducing requirement risk. Cost: interaction-heavy screens need care, every interaction is
a round trip, and Livewire's public properties are a genuine security footgun that the team must
understand.

**B. Inertia + React (or Vue) + Tailwind.** Richer client-side interaction; better if the inventory
screen turns out to need heavy offline-ish behaviour. Rejected: it doubles the skill surface for
maintenance handover, adds a frontend build to every change, and buys interaction quality this
application does not need. The team would spend sprint 1 on plumbing rather than on the asset model.

**C. API-only Laravel + a separate frontend.** Maximum flexibility, and the right answer if a mobile
app were confirmed. Rejected: no mobile app is in scope, and it would be the most expensive option
to build and hand over. Revisit if the customer confirms a native app requirement.

**D. Plain Blade with no Livewire.** Simplest possible. Rejected: the filtering, searching and
inventory-counting flows would each need hand-written JavaScript, which ends up as a worse version
of Livewire.

## Consequences

**Positive:** one language for the whole team; server-side authorization is the default path;
screens can be built and demoed within a single sprint; handover to a PHP-literate IT team is
realistic.

**Negative:**
- Every interaction is a network round trip. On a school wifi during kiểm kê this could be felt —
  the counting screen must be designed to tolerate latency, and this should be tested on the real
  devices early.
- **Livewire public properties are client-writable.** Every action method must re-authorize
  server-side; a trusted ID or amount held in a public property is a real vulnerability. This is
  written into the `livewire-blade-ui` skill and is a `code-reviewer` blocker.
- If the customer later requires genuine offline operation, this decision must be revisited with a
  new ADR — Livewire cannot do it.

**Follow-up:** confirm early whether inventory counting must work without a network. That single
answer is the main thing that could invalidate this decision, so ask it during discovery rather
than after the inventory epic is built.
