@vite('resources/css/app.css')
<x-filament-panels::page>
  <div class="w-full sm:w-1/2 mb-2">
    <div class="flex items-center gap-3 bg-white dark:bg-gray-900 rounded-full p-2 px-4">
      <x-heroicon-o-magnifying-glass class="w-5 h-5 text-gray-500" />
      <input
        type="text"
        wire:model.debounce.500ms="search"
        placeholder="Cari surat..."
        class="w-full bg-transparent text-gray-900 dark:text-gray-200 rounded-full border-none border-0 focus:ring-0 focus:outline-none"
      />
    </div>
  </div>

  <div class="w-full">
    @foreach ($accordionData as $section)
    <div
      wire:key="accordion-{{ $section['id'] }}"
      x-data="{
        open: false,
        currentPage: 1,
        perPage: 5,
        kelas: '{{ $classId }}',
        surah: '{{ $section['surah'] }}',
        searchQuery: '',
        originalData: {{ json_encode($section['data']) }},
        get totalPages() {
          return Math.ceil(this.filteredData().length / this.perPage);
        },
        filteredData() {
          return this.originalData.filter(item => {
            const query = this.searchQuery.toLowerCase();
            return (
              String(item.student_name)?.toLowerCase().includes(query) ||
              String(item.from)?.toLowerCase().includes(query) ||
              String(item.to)?.toLowerCase().includes(query)
            );
          });
        },
        paginatedData() {
          const start = (this.currentPage - 1) * this.perPage;
          return this.filteredData().slice(start, start + this.perPage);
        },
        changePerPage(val) {
          this.perPage = val;
          this.currentPage = 1;
        }
      }"
      class="overflow-hidden mb-4">
      <div class="bg-white dark:bg-gray-900">
        <button
          @click="open = !open"
          type="button"
          class="flex items-center justify-between text-gray-900 dark:text-gray-200 border border-gray-300 w-full py-5 px-6 rounded-xl text-left font-bold md:text-xl hover:bg-gray-800">
            <span>{{ $section['surah'] }}</span>
          <div class="flex items-center gap-8">
            <x-heroicon-o-chevron-down class="w-5 aspect-square transition-transform duration-300 text-gray-600" x-bind:class="{ 'rotate-180': open }" />
          </div>
        </button>
      </div>

      <div class="wrapper transition-all mt-5 duration-200 ease-in-out max-h-0 rounded-xl bg-white dark:bg-gray-900"
        x-bind:class="{ 'max-h-[1000px] border border-gray-300': open }">
        {{-- Header --}}
        <div class="mb-4 flex p-6 justify-between items-center">
          <div class="relative w-max sm:w-64 bg-white dark:bg-gray-900 text-gray-900 flex">
            <x-heroicon-o-magnifying-glass class="w-5 aspect-square absolute right-3 top-[70%] transform -translate-y-1/2 text-gray-500 dark:text-gray-400" />
            <input
              type="text"
              placeholder="Search..."
              maxlength="30"
              class="w-full pl-10 pr-4 bg-gray-100 dark:bg-gray-800 py-3 border border-gray-300 rounded-lg text-sm text-gray-900 dark:text-white"
              x-model="searchQuery"
              x-on:input="currentPage = 1" />
          </div>
          <div class="appearance-none h-full rounded-lg bg-white dark:bg-gray-900">
            <a href="{{ route('filament.teacher.resources.memorizes.create', ['kelas' => $classId, 'surah' => $section['surah']]) }}" class="h-full px-4 py-2 border border-gray-300 rounded-lg flex transition-all">
              <x-heroicon-o-plus class="w-5 aspect-square m-auto" />
            </a>
          </div>
        </div>

        {{-- Table --}}
        <div class="space-y-2 font-medium rounded-lg">
          <div class="block shadow-sm overflow-hidden mb-0">
            <div class="overflow-x-auto">
              <table class="w-full">
                <thead class="">
                  <tr>
                    <th class="text-left px-6 py-4 text-sm font-semibold">No</th>
                    @foreach ($columns as $col)
                    <th class="text-left px-6 py-4 text-sm font-semibold {{ $col['className'] ?? '' }}">
                      {{ $col['header'] }}
                    </th>
                    @endforeach
                    @if ($onEdit || $onDelete)
                    <th class="text-left px-6 py-4 text-sm font-semibold">Aksi</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                  <template x-for="(row, index) in paginatedData()" :key="row.id">
                    <tr class="transition-colors">
                      <td class="px-6 py-4 w-max">
                        <span class="text-sm" x-text="(currentPage - 1) * perPage + index + 1"></span>
                      </td>
                      @foreach ($columns as $col)
                      @if ($col['key'] === 'complete')
                      <td class="px-6 py-4" x-text="row['{{ $col['key'] }}'] === 1 ? 'Selesai' : 'Belum Selesai'"></td>
                      @else
                      <td class="px-6 py-4" x-text="row['{{ $col['key'] }}'] ?? '-'"></td>
                      @endif
                      @endforeach
                      @if ($onEdit || $onDelete)
                      <td class="px-6 py-4">
                        <div class="flex items-center space-x-2 gap-2">
                          @if ($onEdit)
                          <a
                            class="p-2"
                            title="Edit"
                            :href="`/teacher/memorizes/${row.id}/edit/${kelas}/${surah}`">
                            <x-heroicon-o-pencil class="w-4 h-4 text-yellow-500" />
                          </a>
                          @endif
                        </div>
                      </td>
                      @endif
                    </tr>
                  </template>
                </tbody>
              </table>

              <div x-show="paginatedData().length === 0" class="text-center py-12">
                <p class="text-gray-400">Tidak ada data ditemukan</p>
              </div>
            </div>
          </div>
        </div>

        {{-- Pagination Footer --}}
        <div class="flex p-6 justify-between items-center border-t border-gray-300">
          {{-- Previous --}}
          <button
            class="px-4 py-2 border border-gray-300 rounded-lg flex cursor-pointer"
            :disabled="currentPage === 1"
            @click="currentPage--"
            :class="{ 'opacity-50 cursor-not-allowed': currentPage === 1 }">
            Previous
          </button>

          {{-- Per Page Dropdown --}}
          <div>
            <select
              class="appearance-none border border-gray-300 rounded-lg pe-10 py-2 cursor-pointer bg-white text-gray-950 dark:bg-gray-800 dark:text-white"
              @change="changePerPage(parseInt($event.target.value))">
              <option value="5" :selected="perPage === 5">5</option>
              <option value="10" :selected="perPage === 10">10</option>
              <option value="20" :selected="perPage === 20">20</option>
              <option value="50" :selected="perPage === 50">50</option>
            </select>
          </div>

          {{-- Next --}}
          <button
            class="px-4 py-2 border border-gray-300 rounded-lg flex cursor-pointer"
            :disabled="currentPage === totalPages"
            @click="currentPage++"
            :class="{ 'opacity-50 cursor-not-allowed': currentPage === totalPages }">
            Next
          </button>
        </div>
      </div>
    </div>
    @endforeach

  </div>

</x-filament-panels::page>
