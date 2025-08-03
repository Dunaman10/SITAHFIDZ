{{-- resources/views/filament/teacher/pages/class-detail.blade.php --}}

{{-- PASTIKAN BARIS @vite('resources/css/app.css') SUDAH DIHAPUS DARI SINI --}}

<x-filament-panels::page>

    {{-- Input Pencarian Surah --}}
    <div class="mt-6">
        <label for="search-surah" class="sr-only">Cari Surah...</label>
        <div class="relative rounded-md shadow-sm">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-">
                {{-- <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 3a7.5 7.5 0 100 15 7.5 7.5 0 000-15zM21 21l-4.35-4.35" />
                </svg> --}}
              
            </div>
            <input type="text" id="search-surah" name="search-surah"
                   class="block w-full rounded-lg border-0 py-1.5
                          pl-11 pr-3 {{-- Sesuaikan pl- ini agar ikon dan teks tidak tumpang tindih. pl-11 biasanya cukup. --}}
                          text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-700 dark:text-white dark:ring-gray-600 dark:placeholder:text-gray-400 dark:focus:ring-primary-500"
                   placeholder="Cari Surah..."
                   wire:model.live="search" {{-- Ini yang penting untuk Livewire --}}
            >
        </div>
    </div>

    {{-- Bagian Daftar Surah --}}
    <div class="mt-8 space-y-4">
        @forelse($surahs as $surah) {{-- Menggunakan variabel $surahs --}}
            <div class="fi-list-item flex items-center justify-between rounded-lg bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10">
                <span class="text-gray-950 dark:text-white">{{ $surah->id }}. {{ $surah->surah_name }}</span>


                {{-- Tombol dropdown untuk detail surah atau aksi --}}
                <button type="button" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                    </svg>
                    
                </button>
            </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400">Tidak ada surah ditemukan.</p>
        @endforelse
    </div>

</x-filament-panels::page>