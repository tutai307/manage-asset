import './bootstrap';

/**
 * Read an English sentence aloud with the browser's built-in text-to-speech.
 */
window.speakEnglish = (text) => {
    if (!('speechSynthesis' in window)) {
        return;
    }

    window.speechSynthesis.cancel();

    const utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = 'en-US';
    utterance.rate = 0.9;

    const voice = window.speechSynthesis.getVoices().find((v) => v.lang.startsWith('en'));
    if (voice) {
        utterance.voice = voice;
    }

    window.speechSynthesis.speak(utterance);
};

/**
 * AM-006: speak instead of typing.
 *
 * Uses the browser's own speech recognition (Chrome and Edge). Where it is missing the mic button
 * stays hidden and typing still works, so the feature is additive.
 *
 * @param {{notAllowed: string, noSpeech: string, failed: string}} messages localised error strings
 */
window.speechInput = (messages) => ({
    supported: false,
    listening: false,
    error: '',
    recognition: null,

    init() {
        const Recognition = window.SpeechRecognition || window.webkitSpeechRecognition;

        if (!Recognition) {
            return;
        }

        this.supported = true;
        this.recognition = new Recognition();
        this.recognition.lang = 'en-US';
        this.recognition.interimResults = true;
        this.recognition.continuous = false;

        this.recognition.onresult = (event) => {
            let transcript = '';
            for (let i = event.resultIndex; i < event.results.length; i++) {
                transcript += event.results[i][0].transcript;
            }

            this.$wire.set('message', transcript.trim(), false);
        };

        this.recognition.onerror = (event) => {
            this.listening = false;
            this.error =
                event.error === 'not-allowed'
                    ? messages.notAllowed
                    : event.error === 'no-speech'
                      ? messages.noSpeech
                      : messages.failed;
        };

        this.recognition.onend = () => {
            this.listening = false;
        };

        // Stop the microphone when the student leaves the page.
        window.addEventListener('beforeunload', () => this.recognition?.abort());
    },

    toggle() {
        if (!this.supported) {
            return;
        }

        this.error = '';

        if (this.listening) {
            this.recognition.stop();
            return;
        }

        try {
            this.recognition.start();
            this.listening = true;
        } catch {
            this.listening = false;
            this.error = messages.failed;
        }
    },
});
