<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>

    <div
        x-data="{
            recorder: null,
            chunks: [],
            recording: false,
            timer: 0,
            hasNewRecord: false,
            interval: null,

            start() {
                navigator.mediaDevices.getUserMedia({ audio: true })
                    .then(stream => {
                        this.recorder = new MediaRecorder(stream);
                        this.recorder.start();
                        this.recording = true;
                        this.chunks = [];
                        this.timer = 0;

                        this.interval = setInterval(() => this.timer++, 1000);

                        this.recorder.ondataavailable = e => {
                            this.chunks.push(e.data);
                        };

                        this.recorder.onstop = () => {
                            clearInterval(this.interval);

                            const blob = new Blob(this.chunks, { type: 'audio/wav' });

                            const file = new File(
                                [blob],
                                'rekaman-' + Date.now() + '.wav',
                                { type: 'audio/wav' }
                            );

                            $wire.upload('data.audio', file, () => {
                                this.hasNewRecord = true;
                                this.$refs.player.src = URL.createObjectURL(blob);
                            });

                            this.chunks = [];
                        };
                    })
                    .catch(() => alert('Mic tidak diizinkan.'));
            },

            stop() {
                this.recording = false;
                this.recorder.stop();
            }
        }"
        class="space-y-2"
    >
        {{-- Tombol Rekam --}}
        <button
            x-show="!recording"
            x-on:click="start()"
            type="button"
            class="px-4 py-2 bg-primary-600 text-white rounded-lg"
        >
            🎙 Rekam Suara
        </button>

        {{-- Tombol Stop --}}
        <button
            x-show="recording"
            x-on:click="stop()"
            type="button"
            class="px-4 py-2 bg-danger-600 text-white rounded-lg"
        >
            ⛔ Stop ( <span x-text="timer"></span>s )
        </button>

        {{-- Player Rekaman Baru --}}
        <audio x-ref="player" controls class="w-full mt-2" x-show="hasNewRecord"></audio>

    </div>
</x-dynamic-component>
