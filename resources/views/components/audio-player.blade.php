<p class="text-sm font-semibold mb-1">Rekaman Audio</p>

@if (!empty($record->audio))
    <audio controls class="w-full mt-2">
        <source src="{{ asset('storage/' . $record->audio) }}" type="audio/webm">
        Browser tidak mendukung audio.
    </audio>
@else
    <p class="text-gray-500 italic">Belum ada rekaman</p>
@endif
