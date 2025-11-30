<?php

namespace App\Filament\Teacher\Resources\MemorizeResource\Pages;

use App\Filament\Teacher\Pages\ClassDetail;
use App\Filament\Teacher\Resources\MemorizeResource;
use App\Models\Student;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Forms\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EditMemorize extends EditRecord
{
  protected static string $resource = MemorizeResource::class;


  public ?int $id = null;
  public ?string $kelas = null;
  public ?string $surah = null;
  public ?string $audio = null;


  public function getBreadcrumbs(): array
  {
    return [];
  }

  public function mount($record = null): void
  {
    parent::mount($record);
    $this->id = $record;
    $this->kelas = request()->route('kelas');
    $this->surah = request()->route('surah');
    $this->fillForm();
  }

  public function getDataSurah(): object
  {
    $surah = DB::table('surah')
      ->select('id', 'surah_name', 'ayat')
      ->where('surah_name', $this->surah)
      ->first();

    return $surah;
  }

  public function getIdTeacher(): int
  {
    return DB::table('teachers')
      ->where('id_users', auth()->id())
      ->value('id');
  }

  public function form(Form $form): Form
  {
    return $form->schema([
      Hidden::make('id_kelas')
        ->default($this->kelas),

      Hidden::make('id_surah')
        ->default($this->getDataSurah()->id ?? null),

      Hidden::make('id_teacher')
        ->default($this->getIdTeacher()),

      View::make('surah_name')
        ->label('Surah')
        ->view('components.surah-card')
        ->viewData([
          'surah' => $this->surah ?? '',
          'ayat' => $this->getDataSurah()->ayat ?? 0,
        ])
        ->columnSpanFull(),

      Select::make('id_student')
        ->label('Nama Santri / Santriwati')
        ->required()
        ->searchable()
        ->placeholder('Masukkan nama santri / santriwati')
        ->relationship('student', 'student_name')
        ->options(
          Student::whereHas('class', function ($query) {
            $query->where('class_id', $this->kelas);
          })->pluck('student_name', 'id')
        )
        ->columnSpan('full'),

      Grid::make()
        ->schema([
          TextInput::make('from')
            ->label('Halaman Surah (Dari)')
            ->numeric()
            ->required()
            ->placeholder('5'),

          TextInput::make('to')
            ->label('Halaman Surah (Sampai)')
            ->numeric()
            ->required()
            ->placeholder('10'),
        ])
        ->columns(2)
        ->columnSpan('full'),

      // FileUpload::make('audio')
      //   ->label('Atau masukkan file rekaman suara')
      //   ->acceptedFileTypes(['audio/*'])
      //   ->maxSize(10240) // 10MB
      //   ->disk('public')
      //   ->directory('hafalan-audio')
      //   ->preserveFilenames()
      //   ->placeholder('Masukkan file suara santri / santriwati')
      //   ->columnSpan('full'),

      TextInput::make('nilai')
        ->label('Nilai Hafalan')
        ->required(),

      TextInput::make('approved_by')
        ->label('Diperiksa Oleh')
        ->required(),

      Radio::make('complete')
        ->label('')
        ->options([
          '1' => 'Selesai',
          '0' => 'Belum Selesai',
        ])
        ->default('0')
        ->inline()
        ->columnSpanFull(),
    ]);
  }

  protected function getRedirectUrl(): string
  {
    return ClassDetail::getUrl(['classId' => $this->kelas]);
  }

  protected function getHeaderActions(): array
  {
    return [
      Actions\DeleteAction::make()
        ->successRedirectUrl(fn() => ClassDetail::getUrl(['classId' => $this->kelas])),
    ];
  }
}
