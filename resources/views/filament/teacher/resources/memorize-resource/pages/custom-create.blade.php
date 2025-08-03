@vite('resources/css/app.css')

<x-filament-panels::page>
  <div class="space-y-6">

    <div class="bg-[#242427] text-white p-6 rounded-xl">
      <h3 class="text-xl font-semibold">{{ request()->route('surah', 'Surah Belum Dipilih') }}</h3>
    </div>

    <form wire:submit.prevent="create">
      {{ $this->form }}

      <div class="mt-6 flex justify-between">
        <x-filament::button color="gray" tag="a" :href="route('filament.teacher.resources.memorizes.index', ['kelas' => request()->route('kelas')])">
          Cancel
        </x-filament::button>

        <x-filament::button type="submit" color="warning">
          Save
        </x-filament::button>
      </div>
    </form>

  </div>
</x-filament-panels::page>