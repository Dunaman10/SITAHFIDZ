<div
    x-data="audioRecorder('{{ $existingAudio }}')"
    class="flex flex-col items-start space-y-3 p-4 rounded-xl shadow-md"
>
    <!-- Audio Lama -->
    <template x-if="existingAudio && !recording">
        <div class="w-full">
            <p class="px-4 pb-2">🎧 Audio sebelumnya:</p>
            <audio :src="existingAudio" controls class="w-full rounded-md"></audio>
        </div>
    </template>

    <!-- Tombol Rekam -->
    <div class="flex items-center space-x-3 bg-[#ce0670] hover:bg-[#e1328f] text-white rounded-full">
        <button type="button" class="text-sm px-4 py-2" x-show="!recording" @click="startRecording">
            🎙️ Rekam Ulang
        </button>

        <button type="button" class="text-sm px-4 py-2 bg-red-600" x-show="recording" @click="stopRecording">
            ⏹️ Stop
            <template x-if="recording">
                <span class="text-sm text-gray-300">⏱️ <span x-text="recordTime"></span> detik</span>
            </template>
        </button>
    </div>

    <!-- Audio Baru -->
    <audio x-ref="audioPlayer" controls class="mt-2 w-full"></audio>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('audioRecorder', (existingAudioUrl) => ({
        existingAudio: existingAudioUrl || null,
        recording: false,
        mediaRecorder: null,
        audioChunks: [],
        recordTime: 0,
        timerInterval: null,
        maxDuration: 60,

        async startRecording() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                this.mediaRecorder = new MediaRecorder(stream);
                this.audioChunks = [];

                this.mediaRecorder.addEventListener('dataavailable', e => this.audioChunks.push(e.data));

                this.mediaRecorder.addEventListener('stop', () => {
                    clearInterval(this.timerInterval);

                    const blob = new Blob(this.audioChunks, { type: 'audio/webm' });
                    const reader = new FileReader();

                    reader.onloadend = () => {
                        const base64 = reader.result;
                        this.$wire.$set('audio', base64);
                        console.log('✅ Rekaman baru dikirim ke Livewire');
                    };
                    reader.readAsDataURL(blob);

                    const url = URL.createObjectURL(blob);
                    this.$refs.audioPlayer.src = url;
                    this.$refs.audioPlayer.load();
                    this.$refs.audioPlayer.play();

                    stream.getTracks().forEach(track => track.stop());
                });

                this.mediaRecorder.start();
                this.recording = true;
                this.recordTime = 0;

                this.timerInterval = setInterval(() => {
                    this.recordTime++;
                    if (this.recordTime >= this.maxDuration) this.stopRecording();
                }, 1000);

            } catch (err) {
                alert('Izin mikrofon ditolak.');
                console.error(err);
            }
        },

        stopRecording() {
            if (this.mediaRecorder && this.recording) {
                this.mediaRecorder.stop();
                this.recording = false;
            }
        }
    }));
});
</script>
