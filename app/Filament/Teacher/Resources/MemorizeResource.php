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
use Filament\Forms\Components\Split;
use Filament\Forms\Components\View;
use Filament\Forms\Form;

class MemorizeResource extends Resource
{
  protected static ?string $model = Memorize::class;

  protected static ?string $navigationIcon = 'heroicon-o-book-open';

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
      View::make("components.surah-card")
        ->viewData([
          'surah' => '', // Placeholder, adjust as needed
          'ayat' => 0, // Placeholder, adjust as needed
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
        ->enableOpen()
        ->enableDownload()
        ->columnSpan('full'),
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
      'edit' => Pages\EditMemorize::route('/{record}/edit'),
    ];
  }
}
