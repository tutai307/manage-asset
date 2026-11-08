import './bootstrap';

/**
 * Read English aloud.
 *
 * The browser's own voice is tried first. On some Windows machines Chrome and Edge accept the
 * utterance but never start speaking and never report an error, so a watchdog switches to Piper,
 * a voice model that runs inside the page (WebAssembly) and plays through ordinary audio. Only the
 * model files are downloaded; the text never leaves the browser.
 */
const BROWSER_VOICE_TIMEOUT_MS = 1500;
const PIPER_VOICE = 'en_US-hfc_female-medium';

let browserVoiceBroken = !('speechSynthesis' in window);
let request = 0;
let currentAudio = null;
const piperSessions = new Map();
const loadedVoices = new Set();
const clips = new Map();

const notify = (message) => {
    if (message) {
        window.dispatchEvent(new CustomEvent('notify', { detail: { message } }));
    }
};

/**
 * One Piper session per voice. The library keeps a single shared instance whose model is loaded
 * once, so the shared slot is cleared before a different voice is created.
 */
const piper = (voiceId) => {
    if (!piperSessions.has(voiceId)) {
        const session = import('@mintplex-labs/piper-tts-web')
            .then(({ TtsSession, WASM_BASE }) => {
                TtsSession._instance = null;

                return TtsSession.create({
                    voiceId,
                    // No onnxWasm: the runtime loads the copy Vite bundles with this app. The
                    // library's default points at an older CDN build that no longer matches.
                    wasmPaths: {
                        onnxWasm: undefined,
                        piperData: `${WASM_BASE}.data`,
                        piperWasm: `${WASM_BASE}.wasm`,
                    },
                });
            })
            .then((created) => {
                loadedVoices.add(voiceId);
                return created;
            })
            .catch((error) => {
                piperSessions.delete(voiceId);
                throw error;
            });

        piperSessions.set(voiceId, session);
    }

    return piperSessions.get(voiceId);
};

const synthesize = async (text, voiceId) => {
    const key = `${voiceId}\n${text}`;

    if (!clips.has(key)) {
        const session = await piper(voiceId);
        clips.set(key, URL.createObjectURL(await session.predict(text)));
    }

    return clips.get(key);
};

const speakWithPiper = async (text, id) => {
    try {
        if (!loadedVoices.has(PIPER_VOICE)) {
            notify(document.body.dataset.speechLoading);
        }

        const url = await synthesize(text, PIPER_VOICE);

        if (id !== request) {
            return;
        }

        currentAudio = new Audio(url);
        await currentAudio.play();
    } catch {
        if (id === request) {
            notify(document.body.dataset.speechFailed);
        }
    }
};

window.stopSpeaking = () => {
    request++;
    window.speechSynthesis?.cancel();
    currentAudio?.pause();
    currentAudio = null;
};

window.speakEnglish = (text) => {
    window.stopSpeaking();
    const id = request;

    if (browserVoiceBroken) {
        speakWithPiper(text, id);
        return;
    }

    const utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = 'en-US';
    utterance.rate = 0.9;

    const voice = window.speechSynthesis.getVoices().find((v) => v.lang.startsWith('en'));
    if (voice) {
        utterance.voice = voice;
    }

    const fallBack = () => {
        clearTimeout(watchdog);
        if (id !== request) {
            return;
        }
        browserVoiceBroken = true;
        window.speechSynthesis.cancel();
        speakWithPiper(text, id);
    };

    const watchdog = setTimeout(fallBack, BROWSER_VOICE_TIMEOUT_MS);
    utterance.onstart = () => clearTimeout(watchdog);
    utterance.onerror = (event) => {
        if (event.error !== 'interrupted' && event.error !== 'canceled') {
            fallBack();
        }
    };

    // Chrome drops an utterance that is garbage-collected before it starts.
    window.speakEnglish.utterance = utterance;
    window.speechSynthesis.speak(utterance);
};

/**
 * A companion's voice: always Piper, so the page owns the audio and can measure its loudness to
 * move the character's mouth.
 */
let audioContext = null;

const unlockAudio = () => {
    try {
        audioContext ??= new AudioContext();
        audioContext.resume();
    } catch {
        audioContext = null;
    }
};

/**
 * Report the audio's loudness (0…1) every frame until it stops. Without a running AudioContext the
 * mouth still moves, on a steady rhythm instead of the real sound.
 */
const meter = (audio, onLevel) => {
    let analyser = null;

    if (audioContext?.state === 'running') {
        analyser = audioContext.createAnalyser();
        analyser.fftSize = 512;
        audioContext.createMediaElementSource(audio).connect(analyser).connect(audioContext.destination);
    }

    const samples = new Uint8Array(512);

    const frame = (time) => {
        if (audio.paused || audio.ended) {
            onLevel(0);
            return;
        }

        if (analyser) {
            analyser.getByteTimeDomainData(samples);
            let sum = 0;
            for (const sample of samples) {
                sum += ((sample - 128) / 128) ** 2;
            }
            onLevel(Math.min(1, Math.sqrt(sum / samples.length) * 5));
        } else {
            onLevel(0.5 + 0.5 * Math.sin(time / 70));
        }

        requestAnimationFrame(frame);
    };

    requestAnimationFrame(frame);
};

/**
 * @param {string} text
 * @param {{voiceId: string, rate: number, preservesPitch: boolean}} voice
 * @param {(level: number) => void} onLevel
 * @returns {Promise<boolean>} true when the line played to the end, false when it was stopped
 */
const speakAsCompanion = async (text, voice, onLevel) => {
    window.stopSpeaking();
    const id = request;
    const url = await synthesize(text, voice.voiceId);

    if (id !== request) {
        return false;
    }

    const audio = new Audio(url);
    audio.preservesPitch = voice.preservesPitch;
    audio.defaultPlaybackRate = voice.rate;
    audio.playbackRate = voice.rate;
    currentAudio = audio;

    const finished = new Promise((resolve, reject) => {
        audio.onended = () => resolve(true);
        audio.onpause = () => resolve(audio.ended);
        audio.onerror = reject;
    });

    meter(audio, onLevel);
    await audio.play();

    return finished;
};

/**
 * Learners pause to think mid-sentence, so what they say is only sent after this much silence
 * following their last word — or straight away with the "I'm done" button.
 */
const SEND_AFTER_SILENCE_MS = 4000;

/** Browser recognition sessions that end with nothing heard before the call pauses itself. */
const MAX_SILENT_SESSIONS = 4;

/**
 * AM-025: the role-play as a hands-free video call.
 *
 * ready → (start) → speaking → listening → thinking → speaking … → ended.
 * The companion speaks; when it finishes the microphone opens; once the student has been silent
 * for SEND_AFTER_SILENCE_MS the sentence is sent through Livewire; the reply arrives as a
 * `companion-replied` event. Without speech recognition the student types instead and the
 * companion still speaks.
 *
 * @param {{notAllowed: string, noSpeech: string, failed: string, voiceFailed: string}} messages
 */
window.companionCall = (messages) => ({
    state: 'ready',
    subtitles: true,
    caption: '',
    heard: '',
    error: '',
    typing: false,
    finishing: false,
    recognition: null,
    silentTries: 0,
    // What earlier recognition sessions heard; the browser ends a session on a long pause.
    committed: '',
    // 1 → 0 while the silence before sending runs out.
    sendCountdown: 0,
    sendTimer: null,

    init() {
        if (this.$root.dataset.finished === '1') {
            this.state = 'ended';
        }

        try {
            this.subtitles = localStorage.getItem('companion-subtitles') !== 'off';
        } catch {
            // Storage blocked: keep subtitles on.
        }

        const Recognition = window.SpeechRecognition || window.webkitSpeechRecognition;

        if (!Recognition) {
            this.typing = true;
            return;
        }

        this.recognition = new Recognition();
        this.recognition.lang = 'en-US';
        this.recognition.interimResults = true;
        this.recognition.continuous = true;

        this.recognition.onresult = (event) => {
            if (this.state !== 'listening') {
                return;
            }

            let transcript = '';
            for (let i = 0; i < event.results.length; i++) {
                transcript += event.results[i][0].transcript;
            }
            this.heard = `${this.committed} ${transcript}`.trim();

            if (this.heard) {
                this.armSendTimer();
            }
        };

        this.recognition.onerror = (event) => {
            if (event.error === 'not-allowed' || event.error === 'service-not-allowed') {
                this.error = messages.notAllowed;
                this.typing = true;
                this.state = 'paused';
            } else if (event.error !== 'no-speech' && event.error !== 'aborted') {
                this.error = messages.failed;
            }
        };

        this.recognition.onend = () => {
            if (this.state !== 'listening') {
                return;
            }

            // The browser closed the session on a pause: keep what was said and listen on.
            // The send timer, not the end of a session, decides when the sentence is complete.
            this.committed = this.heard;

            if (!this.heard && ++this.silentTries >= MAX_SILENT_SESSIONS) {
                this.error = messages.noSpeech;
                this.state = 'paused';
                return;
            }

            this.openMicrophone();
        };

        // Stop the microphone when the student leaves the page.
        window.addEventListener('beforeunload', () => this.recognition?.abort());
    },

    get voice() {
        return JSON.parse(this.$root.dataset.voice);
    },

    get inCall() {
        return !['ready', 'ended'].includes(this.state);
    },

    start() {
        unlockAudio();
        this.error = '';
        this.say(this.$root.dataset.opening);
    },

    async say(text) {
        this.stopMicrophone();
        this.caption = text;
        this.heard = '';
        this.state = loadedVoices.has(this.voice.voiceId) ? 'speaking' : 'loading';

        let completed = false;

        try {
            completed = await speakAsCompanion(text, this.voice, (level) => {
                if (this.state === 'loading') {
                    this.state = 'speaking';
                }
                this.$root.style.setProperty('--mouth', level.toFixed(2));
            });
        } catch {
            // The voice could not play: the line stays on screen as a subtitle.
            this.error = messages.voiceFailed;
            this.subtitles = true;
            completed = true;
        }

        if (!completed || !this.inCall) {
            return;
        }

        if (this.finishing) {
            this.state = 'ended';
            return;
        }

        this.listen();
    },

    listen() {
        this.state = 'listening';
        this.silentTries = 0;
        this.heard = '';
        this.committed = '';
        this.clearSendTimer();

        if (!this.typing) {
            this.openMicrophone();
        }
    },

    armSendTimer() {
        this.clearSendTimer();
        const sendAt = Date.now() + SEND_AFTER_SILENCE_MS;
        this.sendCountdown = 1;

        this.sendTimer = setInterval(() => {
            const left = sendAt - Date.now();
            this.sendCountdown = Math.max(0, left / SEND_AFTER_SILENCE_MS);

            if (left <= 0) {
                this.sendNow();
            }
        }, 100);
    },

    clearSendTimer() {
        clearInterval(this.sendTimer);
        this.sendTimer = null;
        this.sendCountdown = 0;
    },

    /** "I'm done": send what was heard without waiting for the silence. */
    sendNow() {
        this.clearSendTimer();

        if (this.state === 'listening' && this.heard) {
            this.submit(this.heard);
        }
    },

    /** "Say it again": forget what was heard; the microphone reopens when the session ends. */
    sayAgain() {
        this.clearSendTimer();
        this.heard = '';
        this.committed = '';
        this.silentTries = 0;
        this.stopMicrophone();
    },

    openMicrophone() {
        try {
            this.recognition?.start();
        } catch {
            // Already started.
        }
    },

    stopMicrophone() {
        this.clearSendTimer();

        try {
            this.recognition?.abort();
        } catch {
            // Not started.
        }
    },

    async submit(text) {
        unlockAudio();
        this.error = '';
        this.heard = text;
        this.state = 'thinking';
        this.stopMicrophone();
        this.$wire.set('message', text, false);
        await this.$wire.send();

        // Refused before reaching the AI (e.g. validation): no reply event came, so listen again.
        if (this.state === 'thinking') {
            this.listen();
        }
    },

    /** The typing fallback, also used where the browser cannot recognise speech. */
    typed() {
        if (this.state === 'ready') {
            this.state = 'paused';
        }
        this.submit(this.$wire.message);
    },

    toggleTyping() {
        this.typing = !this.typing || !this.recognition;

        if (this.typing) {
            this.stopMicrophone();
        } else if (this.state === 'listening') {
            this.openMicrophone();
        }
    },

    onReply(detail) {
        const { text, finished } = Array.isArray(detail) ? detail[0] : detail;
        this.finishing = finished;

        if (this.state !== 'ended') {
            this.say(text);
        }
    },

    onFailed() {
        if (this.inCall) {
            this.state = 'paused';
        }
    },

    togglePause() {
        if (this.state === 'paused') {
            this.error = '';
            this.listen();
            return;
        }

        window.stopSpeaking();
        this.stopMicrophone();
        this.state = 'paused';
    },

    repeat() {
        if (this.caption) {
            this.say(this.caption);
        }
    },

    toggleSubtitles() {
        this.subtitles = !this.subtitles;

        try {
            localStorage.setItem('companion-subtitles', this.subtitles ? 'on' : 'off');
        } catch {
            // Storage blocked: the choice lasts for this page only.
        }
    },

    end() {
        window.stopSpeaking();
        this.stopMicrophone();
        this.state = 'ended';
        this.$root.style.setProperty('--mouth', '0');
    },
});
