<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\MemorizeResource\Pages;
use App\Filament\Teacher\Resources\MemorizeResource\RelationManagers;
use App\Models\Memorize;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\View;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Log;

class MemorizeResource extends Resource
{
  protected static ?string $model = Memorize::class;

  protected static ?string $navigationIcon = 'heroicon-o-book-open';
  protected static ?string $navigationLabel = 'Hafalan';

  public static function shouldRegisterNavigation(): bool
  {
    return false;
  }

  public static function getNavigationItems(): array
  {
    return [];
  }

  public $kelas;
  public $surah;

  public function mount($record = null): void
  {
    parent::mount($record);

    // Initialize any properties or perform actions needed on mount
    $this->kelas = request()->route('kelas') ?? '';
    $this->surah = request()->route('surah') ?? '';
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        //
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
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
      View::make('surah_name')
        ->label('Surah')
        ->view('components.surah-card')
        ->viewData(fn($get) => [
          'surah' => $get('surah') ?? '',
          'ayat' => "0",
        ])
        ->columnSpanFull(),
      Select::make('id_student')
        ->label('Nama Santri / Santriwati')
        ->required()
        ->searchable()
        ->placeholder('Masukkan nama santri / santriwati')
        ->relationship('student', 'student_name')
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

      FileUpload::make('audio')
        ->label('Rekam Suara')
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
      'data' => Pages\Memorize::route('/data/{kelas}'),
      'create' => Pages\CreateMemorize::route('/data/{kelas}/create/{surah}'),
      'edit' => Pages\EditMemorize::route('/{record}/edit/{kelas}/{surah}'),
    ];
  }
}
