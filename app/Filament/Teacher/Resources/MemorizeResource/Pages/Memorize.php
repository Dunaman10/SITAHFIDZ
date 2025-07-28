<?php

namespace App\Filament\Teacher\Resources\MemorizeResource\Pages;

use App\Filament\Teacher\Resources\MemorizeResource;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;


class Memorize extends Page
{
  protected static string $resource = MemorizeResource::class;
  public string $isOpen = "";

  public function toggle(string $id)
  {
    $this->isOpen = $this->isOpen === $id ? "" : $id;
  }

  protected static string $view = 'filament.teacher.resources.memorize-resource.pages.memorize';
  protected static ?string $navigationIcon = 'heroicon-o-book-open';
  public string $kelas;

  public function mount(string $kelas): void
  {
    $this->kelas = $kelas;
  }

  public function getViewData(): array
  {
    return [
      'accordionData' => $this->getAccordionData(),
      'openSection' => '1', // atau dari state Livewire
      'columns' => $this->getColumns(),
      'onEdit' => true,
      'onDelete' => true,
      'kelas' => $this->kelas,
    ];
  }

  protected function getAccordionData(): array
  {
    $rawData = DB::table('memorizes')
      ->select(
        'memorizes.id_surah',
        'surah.surah_name as surah_name',
        'memorizes.id',
        'students.student_name as student_name',
        'memorizes.from',
        'memorizes.to',
        'memorizes.audio',
        'memorizes.complete'
      )
      ->join('surah', 'memorizes.id_surah', '=', 'surah.id')
      ->join('students', 'memorizes.id_student', '=', 'students.id')
      ->join('teachers', 'memorizes.id_teacher', '=', 'teachers.id')
      ->join('class_teacher', 'teachers.id', '=', 'class_teacher.id_teacher')
      ->join('classes', 'class_teacher.id_class', '=', 'classes.id')
      ->where('classes.id', $this->kelas)
      ->orderBy('memorizes.id_surah')
      ->get();

    // Group by surah
    $grouped = $rawData->groupBy('id_surah');

    return $grouped->map(function ($items, $idSurah) {
      return [
        'id' => $idSurah,
        'surah' => $items[0]->surah_name,
        'data' => $items->map(function ($item) {
          return [
            'id' => $item->id,
            'student_name' => $item->student_name,
            'from' => $item->from,
            'to' => $item->to,
            'audio' => $item->audio,
            'complete' => $item->complete,
          ];
        })->toArray()
      ];
    })->values()->toArray();
  }

  protected function getColumns(): array
  {
    return [
      ['header' => 'Siswa', 'key' => 'student_name'],
      ['header' => 'Mulai', 'key' => 'from'],
      ['header' => 'Selesai', 'key' => 'to'],
      ['header' => 'Audio', 'key' => 'audio'],
      ['header' => 'Status', 'key' => 'complete'],
    ];
  }
}
