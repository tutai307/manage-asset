# ADR-0006 — In-page Piper voice when the browser's voice does not start

- **Status:** Accepted
- **Date:** 2026-10-21
- **Deciders:** delivery lead, customer

## Context

Every speaker button calls `speakEnglish()` in `resources/js/app.js`, which used only the browser's
Web Speech API (`speechSynthesis`). On the customer's development machine (Windows 11, Chrome 155,
Edge and Playwright's Chromium) the buttons were silent (AM-B01). Measured on 2026-10-21:

- `speechSynthesis.speak()` is accepted (`speaking === true`) but neither `start` nor `error` ever
  fires — also on a blank `data:` page, so the app's code is not the cause.
- Windows' own voices work (SAPI and OneCore both synthesise), and Chrome plays ordinary audio
  (Web Audio runs). Stopping the Nahimic audio processes changed nothing.

The failure is inside Chromium's speech path and cannot be fixed from the app. School computer
labs may hit the same thing, and the competition demo depends on listening practice.

## Decision

1. The browser's voice is still tried first. If it has not started within 1.5 s, or reports an
   error other than `interrupted`/`canceled`, the page switches to **Piper**
   (`@mintplex-labs/piper-tts-web`, MIT) for the rest of the page's life.
2. Piper runs in the page (ONNX Runtime WebAssembly) and plays through an ordinary `Audio`
   element. It is loaded with a dynamic `import()`, so pages whose browser voice works never
   download it.
3. Voice `en_US-hfc_female-medium` (~63 MB). It is downloaded once from Hugging Face and kept in the
   browser's Origin Private File System. The phonemiser files come from jsDelivr. The ONNX
   runtime is the copy Vite bundles into `public/build`: the library's default points at a
   cdnjs build (1.18.0) that does not match the installed runtime and returns 404.
4. `window.stopSpeaking()` stops both voices. No view calls `speechSynthesis` directly.
5. The first switch shows the existing `notify` toast (`common.speech_loading`), and a failure
   shows `common.speech_failed`.

### Addendum — companion voices (AM-024, AM-025)

The role-play companions always speak through Piper, never the browser voice. The page must own
the audio to measure its loudness for the mouth animation, and each character needs the same
voice on every machine. Each companion has one Piper voice (`App\Enums\Companion::voice()`), with
playback rate and pitch adjusted for character. The library keeps one shared session, so the
page creates and caches one session per voice. Each voice is a separate ~63 MB download on first
use.

## Options considered

**A. In-page Piper fallback (chosen).** Free, needs no key, and no text leaves the browser. Only
model files are fetched. Natural voice. Costs: ~63 MB on first use (about 40 s on the dev machine),
and the first word waits 1.5 s on machines where the browser voice is broken.

**B. Cloud text-to-speech (Google, Azure, OpenAI).** Best voice, but needs a key, costs per use,
and sends learning text to another provider.

**C. Only tell the student the browser cannot speak.** Cheapest, but the button stays silent.

## Consequences

- Learning content is still synthesised on the device. No student data is involved.
- The first fallback needs internet access to Hugging Face and jsDelivr. Later uses work offline.
- There is no JavaScript test runner in the repo. The behaviour was verified end to end in Chrome
  and Edge on 2026-10-21: the first phrase played after ~40 s, later phrases after ~3 s, a 17 s
  passage played in full, and stop silenced a pending phrase. `SkillExerciseTest` guards the view
  wiring.
