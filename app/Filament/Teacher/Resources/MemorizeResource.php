<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\MemorizeResource\Pages;
use App\Models\ClassTeacher;
use App\Models\Memorize;
use App\Models\MentorStudent;
use App\Models\Surah;
use DateTime;
use Dom\Text;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\View;
use Filament\Forms\Form;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use PhpParser\Node\Stmt\Label;

class MemorizeResource extends Resource
{
  protected static ?string $model = Memorize::class;
  protected static string $view = 'teacher.memorizes.index';
  protected static ?string $navigationIcon = 'heroicon-o-book-open';
  protected static ?string $navigationLabel = 'Setor Hafalan';
  protected static ?string $pluralLabel = 'Setor Hafalan Santri';
  protected static ?string $modelLabel = 'Setoran Hafalan';

  // Sembunyikan dari navbar
  // public static function shouldRegisterNavigation(): bool
  // {
  //   return false;
  // }

  // public static function getNavigationItems(): array
  // {
  //   return [];
  // }

  public static function getEloquentQuery(): Builder
  {
    $user = Auth::user();
    $teacher = $user->teacher;

    if (!$teacher) {
      return parent::getEloquentQuery()->whereNull('id');
    }

    // Ambil id santri binaan
    $studentIds = MentorStudent::where('id_teacher', $teacher->id)
      ->pluck('id_student');

    return parent::getEloquentQuery()
      ->whereIn('id_student', $studentIds)
      ->orderBy('created_at', 'desc'); // BONUS: langsung order newest first
  }


  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('student.student_name')
          ->label('Nama Santri')
          ->searchable(),

        TextColumn::make('surah.surah_name')
          ->label('Nama Surat'),

        TextColumn::make('surah.juz')
          ->label('Juz')
          ->alignCenter(),

        TextColumn::make('nilai_avg')
          ->label('Nilai Rata-Rata')
          ->alignCenter(),

        TextColumn::make('created_at')
          ->label('Tanggal')
          ->date('d M Y')

      ])
      ->defaultSort('created_at', 'desc')
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\ViewAction::make(),
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ]);
  }

  public static function form(Form $form): Form
  {
    return $form->schema([

      Select::make('id_student')
        ->relationship('student', 'student_name')
        ->label('Nama Santri / Santriwati')
        ->required()
        ->placeholder('Masukkan nama santri / santriwati')
        ->columnSpan('full')
        ->options(function () {
          $teacher = Auth::user()->teacher;

          if (!$teacher) return [];

          return MentorStudent::where('id_teacher', $teacher->id)
            ->with('student')
            ->get()
            ->mapWithKeys(fn($item) => [
              $item->id_student => $item->student->student_name
            ]);
        }),

      Select::make('juz')
        ->label('Juz')
        ->options([
          1 => 'Juz 1',
          2 => 'Juz 2',
          3 => 'Juz 3',
          4 => 'Juz 4',
          5 => 'Juz 5',
          6 => 'Juz 6',
          7 => 'Juz 7',
          8 => 'Juz 8',
          9 => 'Juz 9',
          10 => 'Juz 10',
          11 => 'Juz 11',
          12 => 'Juz 12',
          13 => 'Juz 13',
          14 => 'Juz 14',
          15 => 'Juz 15',
          16 => 'Juz 16',
          17 => 'Juz 17',
          18 => 'Juz 18',
          19 => 'Juz 19',
          20 => 'Juz 20',
          21 => 'Juz 21',
          22 => 'Juz 22',
          23 => 'Juz 23',
          24 => 'Juz 24',
          25 => 'Juz 25',
          26 => 'Juz 26',
          27 => 'Juz 27',
          28 => 'Juz 28',
          29 => 'Juz 29',
          30 => 'Juz 30',
        ])
        ->reactive()
        ->afterStateUpdated(fn($state, callable $set) => $set('id_surah', null))
        ->placeholder('Pilih Juz …')
        ->required(),

      Select::make('id_surah')
        ->label('Nama Surah')
        ->options(function (callable $get) {
          $juz = $get('juz');

          if (!$juz) return [];

          return Surah::where('juz', $juz)
            ->orderBy('id')
            ->pluck('surah_name', 'id');
        })
        ->required()
        ->searchable()
        ->preload()
        ->placeholder('Pilih Surah berdasarkan Juz …'),

      FileUpload::make('foto')
        ->label('Upload Foto Santri')
        ->image()
        ->directory('foto-santri')
        ->disk('public')
        ->placeholder('Upload Foto Santri'),

      FileUpload::make('audio')
        ->label('Upload Rekaman Suara Santri')
        ->acceptedFileTypes(['audio/*'])
        ->maxSize(10240) // 10MB
        ->disk('public')
        ->directory('hafalan-audio')
        ->preserveFilenames()
        ->placeholder('Upload suara santri'),

      TextInput::make('from')
        ->label('Dari Ayat')
        ->numeric()
        ->required(),

      TextInput::make('to')
        ->label('Sampai Ayat')
        ->numeric()
        ->required(),

      TextInput::make('approved_by')
        ->label('Diperiksa Oleh')
        ->required(),

      Radio::make('complete')
        ->label('Status')
        ->options([
          '1' => 'Selesai',
          '0' => 'Belum Selesai',
        ])
        ->default('0'),

      Section::make('Penilaian Hafalan')
        ->description('Bagian ini berisi nilai dan kualitas bacaan santri')
        ->schema([

          Select::make('makharijul_huruf')
            ->label('Makharijul Huruf')
            ->options([
              'A' => 'A',
              'B' => 'B',
              'C' => 'C',
              'D' => 'D',
            ]),

          Select::make('shifatul_huruf')
            ->label('Shifatul Huruf')
            ->options([
              'A' => 'A',
              'B' => 'B',
              'C' => 'C',
              'D' => 'D',
            ]),

          Select::make('ahkamul_qiroat')
            ->label('Akhkamul Qiroat')
            ->options([
              'A' => 'A',
              'B' => 'B',
              'C' => 'C',
              'D' => 'D',
            ]),

          Select::make('ahkamul_waqfi')
            ->label('Akhkamul Waqfi')
            ->options([
              'A' => 'A',
              'B' => 'B',
              'C' => 'C',
              'D' => 'D',
            ]),

          Select::make('qowaid_tafsir')
            ->label('Qowaid Tafsir')
            ->options([
              'A' => 'A',
              'B' => 'B',
              'C' => 'C',
              'D' => 'D',
            ]),

          Select::make('tarjamatul_ayat')
            ->label('Tarjamatul Ayat')
            ->options([
              'A' => 'A',
              'B' => 'B',
              'C' => 'C',
              'D' => 'D',
            ]),

        ])
        ->columns(2), // biar lebih enak dilihat



      // View::make('surah_name')
      //   ->label('Surah')
      //   ->view('components.surah-card')
      //   ->viewData(fn($get) => [
      //     'surah' => $get('surah') ?? '',
      //     'ayat' => "0",
      //   ])
      //   ->columnSpanFull(),
      // Select::make('id_student')
      //   ->label('Nama Santri / Santriwati')
      //   ->required()
      //   ->searchable()
      //   ->placeholder('Masukkan nama santri / santriwati')
      //   ->relationship('student', 'student_name')
      //   ->columnSpan('full'),

      // // Jika ingin "from" dan "to" tetap satu baris, gunakan Grid
      // Grid::make()
      //   ->schema([
      //     TextInput::make('from')
      //       ->label('Halaman Surah (Dari)')
      //       ->numeric()
      //       ->required()
      //       ->placeholder('5'),

      //     TextInput::make('to')
      //       ->label('Halaman Surah (Sampai)')
      //       ->numeric()
      //       ->required()
      //       ->placeholder('10'),
      //   ])
      //   ->columns(2)
      //   ->columnSpan('full'),

      // FileUpload::make('audio')
      //   ->label('Masukkan file rekaman suara')
      //   ->acceptedFileTypes(['audio/*'])
      //   ->maxSize(10240) // 10MB
      //   ->disk('public')
      //   ->directory('hafalan-audio')
      //   ->preserveFilenames()
      //   ->placeholder('Masukkan file suara santri / santriwati?')
      //   ->columnSpanFull(),

      // TextInput::make('nilai')
      //   ->label('Nilai Hafalan')
      //   ->required(),

      // TextInput::make('approved_by')
      //   ->label('Diperiksa Oleh')
      //   ->required(),

      // Radio::make('complete')
      //   ->label('')
      //   ->options([
      //     '1' => 'Selesai',
      //     '0' => 'Belum Selesai',
      //   ])
      //   ->default('0')
      //   ->inline()
      //   ->columnSpanFull(),

    ]);
  }

  public static function getRelations(): array
  {
    return [
      //
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListMemorizes::route('/'),
      'create' => Pages\CreateMemorize::route('/create'),
      // 'data' => Pages\Memorize::route('/data/{kelas}'),
      // 'create' => Pages\CreateMemorize::route('/data/{kelas}/create/{surah}'),
      // 'edit' => Pages\EditMemorize::route('/{record}/edit/{kelas}/{surah}'),
    ];
  }
}
