{{-- resources/views/filament/sidebar-class-dropdown.blade.php --}}

{{-- Hapus @vite('resources/css/app.css') dari sini --}}

<div class="fi-sidebar-item p-3">
    <label for="sidebar-class-selector" class="sr-only">Pilih Kelas</label>
    <select id="sidebar-class-selector"
            class="fi-input block w-full rounded-lg border-none py-1.5 pe-4 ps-3 text-base shadow-sm outline-none ring-1 transition duration-75 placeholder:text-gray-500 focus:ring-2 disabled:pointer-events-none disabled:opacity-70 sm:text-sm sm:leading-6
                   bg-white text-gray-950 ring-gray-950/10 dark:bg-white/5 dark:text-white dark:placeholder:text-gray-400 dark:ring-white/10 dark:focus:ring-white/20
                   {{-- Tambahan class spesifik untuk memastikan dark mode --}}
                   dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700"> {{-- Tambahkan class ini --}}
        <option value="" class="dark:bg-gray-800 dark:text-gray-200">-- Pilih Kelas --</option> {{-- Tambahkan class ini --}}
        @foreach($classes as $class)
            <option value="{{ \App\Filament\Teacher\Pages\ClassDetail::getUrl(['classId' => $class->id], panel: 'teacher') }}"
                    class="dark:bg-gray-800 dark:text-gray-200" {{-- Tambahkan class ini --}}
                    @if(request()->route()->getName() == 'filament.teacher.pages.class-detail' && request()->route('classId') == $class->id) selected @endif>
                Kelas {{ $class->class_name }}
            </option>
        @endforeach
    </select>
</div>

<script>
    document.getElementById('sidebar-class-selector').addEventListener('change', function() {
        const url = this.value;
        if (url) {
            window.location.href = url;
        }
    });
</script>