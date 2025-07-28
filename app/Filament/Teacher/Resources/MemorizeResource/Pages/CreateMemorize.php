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

  public ?string $kelas = null;
  public ?string $surah = null;

  public function mount($record = null): void
  {
    parent::mount($record);

    $this->kelas = request()->route('kelas');
    $this->surah = request()->route('surah');
    $this->fillForm();
  }

  protected function getFormSchema(): array
  {
    dd($this->getDataSurah());
    return [
      Forms\Components\View::make("components.surah-card")
        ->viewData($this->getDataSurah())
        ->columnSpanFull(),
      Forms\Components\Select::make('id_student')
        ->label('Nama Santri / Santriwati')
        ->required()
        ->searchable()
        ->placeholder('Masukkan nama santri / santriwati')
        ->options(fn() => Student::where('class', $this->kelas)->pluck('student_name', 'id')->toArray())
        ->columnSpanFull(),

      Forms\Components\Grid::make()
        ->schema([
          Forms\Components\TextInput::make('from')
            ->label('Halaman Surah (Dari)')
            ->numeric()
            ->required()
            ->placeholder('5'),

          Forms\Components\TextInput::make('to')
            ->label('Halaman Surah (Sampai)')
            ->numeric()
            ->required()
            ->placeholder('10'),
        ])
        ->columns(2)
        ->columnSpanFull(),

      Forms\Components\FileUpload::make('audio')
        ->label('Rekam Suara')
        ->acceptedFileTypes(['audio/*'])
        ->maxSize(10240)
        ->disk('public')
        ->directory('hafalan-audio')
        ->preserveFilenames()
        ->columnSpanFull(),
    ];
  }

  public function getDataSurah(): array
  {
    return DB::table('surah')
      ->select('id', 'surah_name', 'ayat')
      ->get()
      ->where('surah_name', $this->surah)
      ->toArray();
  }
}
