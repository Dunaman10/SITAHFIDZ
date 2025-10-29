<?php

namespace App\Filament\Teacher\Resources\MemorizeResource\Pages;

use App\Filament\Teacher\Pages\ClassDetail;
use App\Filament\Teacher\Resources\MemorizeResource;
use App\Models\Student;
use Filament\Actions;
use Filament\Forms\Components\ViewField;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Forms\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class CreateMemorize extends CreateRecord
{
  protected static string $resource = MemorizeResource::class;
  // protected static string $view = 'filament.teacher.resources.memorize-resource.pages.custom-create';

  public ?string $kelas = null;
  public ?string $surah = null;

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
      Hidden::make('audio_base64')
        ->label('Audio Rekaman (Base64)')
        ->default(null),
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

      // Jika ingin "from" dan "to" tetap satu baris, gunakan Grid
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

      ViewField::make('audio')
        ->label('Rekam Suara')
        ->view('components.audio-recorder')
        ->columnSpan('full'),

      FileUpload::make('audio')
        ->label('Atau masukkan file rekaman suara')
        ->acceptedFileTypes(['audio/*'])
        ->maxSize(10240) // 10MB
        ->disk('public')
        ->directory('hafalan-audio')
        ->preserveFilenames()
        ->placeholder('Rekam Suara Santri / Santriwati')
        ->columnSpan('full'),

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
    if (!empty($data['audio_base64']) && str_starts_with($data['audio_base64'], 'data:audio')) {
      [$meta, $content] = explode(',', $data['audio_base64']);
      $audioBinary = base64_decode($content);

      $fileName = 'memorize_' . time() . '.wav';
      $path = 'memorize-audio/' . $fileName;

      Storage::disk('public')->put($path, $audioBinary);

      $data['audio'] = $path;
    }

    unset($data['audio_base64']);

    return $data;
  }

  protected function getRedirectUrl(): string
  {
    return ClassDetail::getUrl(['classId' => $this->kelas]);
  }
  public function delete($id): void
  {
    dd($id);
    $memorize = Memorize::findOrFail($id);
    $memorize->delete();

    // Redirect atau emit event ke parent
    $this->dispatch('deleted');
    session()->flash('success', 'Berhasil dihapus!');
    redirect()->back();
  }
}
