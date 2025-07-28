@vite('resources/css/app.css')

<x-filament-panels::page>
  {{-- Accordion Wrapper --}}
  <div class="w-full">
    @foreach ($accordionData as $section)
    <div
      x-data="{
        open: false,
        currentPage: 1,
        perPage: 2,
        searchQuery: '',
        originalData: {{ json_encode($section['data']) }},
        get totalPages() {
          return Math.ceil(this.filteredData().length / this.perPage);
        },
        filteredData() {
          return this.originalData.filter(item => {
            const query = this.searchQuery.toLowerCase();
            console.log(item, query);
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
      <div class="bg-[#18181B]">
        <button
          @click="open = !open"
          type="button"
          class="flex items-center justify-between text-white border border-white w-full py-5 px-6 rounded-xl text-left font-bold md:text-xl hover:text-gray-800">
          <span>{{ $section['surah'] }}</span>
          <div class="flex items-center gap-8">
            <x-heroicon-o-chevron-down class="w-5 aspect-square transition-transform duration-300" x-bind:class="{ 'rotate-180': open }" />
          </div>
        </button>
      </div>

      <div class="wrapper transition-all mt-5 duration-200 ease-in-out max-h-0 text-white rounded-xl bg-[#18181B]"
        x-bind:class="{ 'max-h-[1000px] border border-white': open }">
        {{-- Header --}}
        <div class="mb-4 flex p-6 justify-between items-center">
          <div class="relative w-max sm:w-64 bg-[#242427] flex">
            <x-heroicon-o-magnifying-glass class="w-5 aspect-square absolute right-3 top-[70%] transform -translate-y-1/2 text-white" />
            <input
              type="text"
              placeholder="Search..."
              maxlength="30"
              class="w-full pl-10 pr-4 !bg-[#242427] py-3 border border-white rounded-lg text-sm"
              x-model="searchQuery"
              x-on:input="currentPage = 1" />
          </div>
          <div class="h-full">
            <a href="{{ route('filament.teacher.resources.memorizes.create', ['kelas' => $kelas, 'surah' => $section['surah']]) }}" class="h-full px-4 py-2 border border-white text-white rounded-lg flex">
              <x-heroicon-o-plus class="w-5 aspect-square m-auto text-white" />
            </a>
          </div>
        </div>

        {{-- Table --}}
        <div class="space-y-2 font-medium rounded-lg">
          <div class="block shadow-sm overflow-hidden mb-0">
            <div class="overflow-x-auto">
              <table class="w-full">
                <thead class="bg-[#242427] text-white">
                  <tr>
                    <th class="text-left px-6 py-4 text-sm font-semibold">#</th>
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
                        <span class="text-sm text-white" x-text="(currentPage - 1) * perPage + index + 1"></span>
                      </td>
                      @foreach ($columns as $col)
                      @if ($col['key'] === 'complete')
                      <td class="px-6 py-4" x-text="row['{{ $col['key'] }}'] === 1 ? 'Complete' : 'Incomplete'"></td>
                      @else
                      <td class="px-6 py-4" x-text="row['{{ $col['key'] }}'] ?? '-'"></td>
                      @endif
                      @endforeach
                      @if ($onEdit || $onDelete)
                      <td class="px-6 py-4">
                        <div class="flex items-center space-x-2 gap-2">
                          @if ($onEdit)
                          <button @click="$wire.call('edit', row.id)" class="p-2" title="Edit">
                            <x-heroicon-o-pencil class="w-4 h-4 text-amber-200" />
                          </button>
                          @endif
                          @if ($onDelete)
                          <button @click="$wire.call('delete', row.id)" class="p-2" title="Delete">
                            <x-heroicon-o-trash class="w-4 h-4 text-red-400 " />
                          </button>
                          @endif
                        </div>
                      </td>
                      @endif
                    </tr>
                  </template>
                </tbody>
              </table>

              <div x-show="paginatedData().length === 0" class="text-center py-12">
                <p class="text-gray-500">Tidak ada data ditemukan</p>
              </div>
            </div>
          </div>
        </div>

        {{-- Pagination Footer --}}
        <div class="flex p-6 justify-between items-center border-t border-white">
          {{-- Previous --}}
          <button
            class="px-4 py-2 border border-white text-white rounded-lg flex"
            :disabled="currentPage === 1"
            @click="currentPage--"
            :class="{ 'opacity-50 cursor-not-allowed': currentPage === 1 }">
            Previous
          </button>

          {{-- Per Page Dropdown --}}
          <div>
            <select
              class="!bg-[#18181B] text-white border border-white rounded-lg px-4 py-2"
              @change="changePerPage(parseInt($event.target.value))">
              <option value="2" :selected="perPage === 2">2</option>
              <option value="5" :selected="perPage === 5">5</option>
              <option value="10" :selected="perPage === 10">10</option>
              <option value="20" :selected="perPage === 20">20</option>
              <option value="50" :selected="perPage === 50">50</option>
            </select>
          </div>

          {{-- Next --}}
          <button
            class="px-4 py-2 border border-white text-white rounded-lg flex"
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