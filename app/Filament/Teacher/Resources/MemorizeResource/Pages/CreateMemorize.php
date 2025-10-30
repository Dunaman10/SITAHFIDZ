<?php

namespace App\Filament\Teacher\Resources\MemorizeResource\Pages;

use App\Filament\Teacher\Pages\ClassDetail;
use App\Filament\Teacher\Resources\MemorizeResource;
use App\Models\Student;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Forms\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateMemorize extends CreateRecord
{
  protected static string $resource = MemorizeResource::class;

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
    $this->kelas = request()->route('kelas');
    $this->surah = request()->route('surah');
    $this->fillForm();
  }

  public function getDataSurah(): object
  {
    return DB::table('surah')
      ->select('id', 'surah_name', 'ayat')
      ->where('surah_name', $this->surah)
      ->first();
  }

  public function getIdTeacher(): int
  {
    return DB::table('teachers')
      ->where('id_users', auth()->id())
      ->value('id');
  }

  protected function registerListeners(): void
  {
    parent::registerListeners();

    // Event listener global Livewire
    $this->listeners['audio-base64-updated'] = 'updateAudioBase64';
  }

  public function updateAudioBase64($data): void
  {
    if (isset($data['base64'])) {
      $this->audio = $data['base64'];
      Log::info('🎧 Audio base64 diterima', ['length' => strlen($this->audio_base64)]);
    }
  }

  public function form(Form $form): Form
  {
    return $form->schema([
      Hidden::make('id_kelas')->default($this->kelas),
      Hidden::make('id_surah')->default($this->getDataSurah()->id ?? null),
      Hidden::make('id_teacher')->default($this->getIdTeacher()),
      Hidden::make('audio')->default(null),

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
          Student::whereHas(
            'class',
            fn($query) =>
            $query->where('class_id', $this->kelas)
          )->pluck('student_name', 'id')
        )
        ->columnSpanFull(),

      Grid::make()->schema([
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
      ])->columns(2)->columnSpanFull(),

      ViewField::make('audio_recorder')
        ->label('Rekam Suara')
        ->view('components.audio-recorder')
        ->columnSpanFull(),

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

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    // pastikan dari wire.set() ke public $audio udah dapet datanya
    if (!empty($this->audio)) {
      // simpan base64 ke field audio
      $data['audio'] = $this->audio;
      logger('✅ Audio berhasil dimasukkan ke data sebelum create');
    } else {
      logger('❌ Audio masih kosong sebelum create');
    }

    return $data;
  }



  protected function getRedirectUrl(): string
  {
    return ClassDetail::getUrl(['classId' => $this->kelas]);
  }
}
