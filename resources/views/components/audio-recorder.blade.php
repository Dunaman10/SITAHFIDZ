<div
    x-data="{
        recording: false,
        mediaRecorder: null,
        audioChunks: [],
        recordTime: 0,
        timerInterval: null,
        maxDuration: 60,
        startRecording() {
            navigator.mediaDevices.getUserMedia({ audio: true }).then(stream => {
                this.mediaRecorder = new MediaRecorder(stream);
                this.audioChunks = [];
                this.mediaRecorder.ondataavailable = e => this.audioChunks.push(e.data);
                this.mediaRecorder.onstop = () => {
                    clearInterval(this.timerInterval);
                    const blob = new Blob(this.audioChunks, { type: 'audio/webm' });
                    const reader = new FileReader();
                    reader.onloadend = () => {
                        const base64 = reader.result;
                        // kirim ke Livewire
                        $wire.set('audio', base64);
                        console.log('✅ base64 dikirim ke Livewire');
                    };
                    reader.readAsDataURL(blob);
                    stream.getTracks().forEach(track => track.stop());
                    const url = URL.createObjectURL(blob);
                    this.$refs.audioPlayer.src = url;
                };
                this.mediaRecorder.start();
                this.recording = true;
                this.recordTime = 0;
                this.timerInterval = setInterval(() => {
                    this.recordTime++;
                    if (this.recordTime >= this.maxDuration) this.stopRecording();
                }, 1000);
            }).catch(err => alert('Izin mikrofon ditolak'));
        },
        stopRecording() {
            if (this.mediaRecorder && this.recording) {
                this.mediaRecorder.stop();
                this.recording = false;
            }
        }
    }"
    class="flex flex-col items-start space-y-3 p-4 rounded-xl shadow-md bg-gray-900/40"
>
    <div class="flex items-center space-x-3">
        <button type="button" class="px-4 py-2 bg-blue-600 text-white rounded-lg" x-show="!recording" @click="startRecording">🎙️ Mulai Rekam</button>
        <button type="button" class="px-4 py-2 bg-red-600 text-white rounded-lg" x-show="recording" @click="stopRecording">⏹️ Stop</button>
        <template x-if="recording">
            <span class="text-sm text-gray-300">⏱️ <span x-text="recordTime"></span> detik</span>
        </template>
    </div>
    <audio x-ref="audioPlayer" controls class="mt-2 w-full"></audio>
</div>
