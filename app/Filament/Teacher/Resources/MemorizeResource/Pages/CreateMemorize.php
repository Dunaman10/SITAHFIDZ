<?php

namespace App\Filament\Teacher\Resources\MemorizeResource\Pages;

use App\Filament\Teacher\Resources\MemorizeResource;
use App\Models\Student;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
use Illuminate\Support\Facades\DB;

class CreateMemorize extends CreateRecord
{
  protected static string $resource = MemorizeResource::class;
  // protected static string $view = 'filament.teacher.resources.memorize-resource.pages.custom-create';


  public ?string $kelas = null;
  public ?string $surah = null;

  public function mount($record = null): void
  {
    parent::mount($record);

    $this->kelas = request()->route('kelas');
    $this->surah = request()->route('surah');
    $this->fillForm();
    dd($this->kelas, $this->surah);
  }

  public function getDataSurah(): array
  {
    return DB::table('surah')
      ->select('id', 'surah_name', 'ayat')
      ->get()
      ->where('surah_name', $this->surah)
      ->toArray();
  }

  public function submit(): void {}
}
