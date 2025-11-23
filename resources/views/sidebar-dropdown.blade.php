{{-- resources/views/filament/sidebar-class-dropdown.blade.php --}}

{{-- Hapus @vite('resources/css/app.css') dari sini --}}

<div class="fi-sidebar-item p-3">
  <label for="sidebar-class-selector" class="sr-only">Pilih Kelas</label>
  <select id="sidebar-class-selector"
    class="fi-input block w-full rounded-lg border-none py-3 pe-4 ps-3 text-base shadow-sm outline-none ring-1 transition duration-75 placeholder:text-gray-500 focus:ring-2 disabled:pointer-events-none disabled:opacity-70 sm:text-sm sm:leading-text-gray-950 ring-gray-950/10 focus:ring-gray-950/20 bg-slate-950 dark:bg-gray-900 dark:text-white cursor-pointer">
    <option value="">Setor Hafalan</option>
    @foreach($classes as $class)
    <option value="{{ \App\Filament\Teacher\Pages\ClassDetail::getUrl(['classId' => $class->id], panel: 'teacher') }}"
      @if(request()->route()->getName() == 'filament.teacher.pages.class-detail' && request()->route('classId') == $class->id) selected @endif>
      {{ $class->class_name }}
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
