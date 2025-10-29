<div
    x-data="audioRecorder"
    class="flex flex-col items-start space-y-3 p-4 rounded-xl shadow-md"
>
    <div class="flex items-center space-x-3">
        <button
            type="button"
            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-black font-semibold rounded-lg transition"
            x-show="!recording"
            @click="startRecording"
        >
            🎙️ Mulai Rekam
        </button>

        <button
            type="button"
            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-black font-semibold rounded-lg transition"
            x-show="recording"
            @click="stopRecording"
        >
            ⏹️ Stop
        </button>

        <template x-if="recording">
            <span class="text-sm text-gray-300">
                ⏱️ <span x-text="recordTime"></span> detik
            </span>
        </template>
    </div>

    <audio x-ref="audioPlayer" controls class="mt-2 w-full"></audio>

    <!-- Binding langsung ke Livewire -->
    <input type="hidden" x-model="audioBase64" wire:model.defer="audio_base64">


</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('audioRecorder', () => ({
        recording: false,
        mediaRecorder: null,
        audioChunks: [],
        audioBase64: '',
        recordTime: 0,
        timerInterval: null,
        maxDuration: 60,

        async startRecording() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                this.mediaRecorder = new MediaRecorder(stream);
                this.audioChunks = [];

                this.mediaRecorder.addEventListener('dataavailable', e => {
                    this.audioChunks.push(e.data);
                });

                this.mediaRecorder.addEventListener('stop', async () => {
                    clearInterval(this.timerInterval);

                    const blob = new Blob(this.audioChunks, { type: 'audio/wav' });
                    const url = URL.createObjectURL(blob);
                    this.$refs.audioPlayer.src = url;

                    const reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = () => {
                      this.audioBase64 = reader.result
                      $wire.set('audio_base64', this.audioBase64)
                      console.log('✅ Base64 terkirim ke Livewire')
                  }

                    stream.getTracks().forEach(track => track.stop());
                });

                this.mediaRecorder.start();
                this.recording = true;
                this.recordTime = 0;

                this.timerInterval = setInterval(() => {
                    this.recordTime++;
                    if (this.recordTime >= this.maxDuration) {
                        this.stopRecording();
                    }
                }, 1000);
            } catch (error) {
                alert('Izin mikrofon ditolak atau tidak tersedia.');
                console.error(error);
            }
        },

        stopRecording() {
            if (this.mediaRecorder && this.recording) {
                this.mediaRecorder.stop();
                this.recording = false;
            }
        },
    }))
});
</script>
