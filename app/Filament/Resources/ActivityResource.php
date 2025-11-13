<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
use App\Models\Activity;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ActivityResource extends Resource
{
  protected static ?string $model = Activity::class;

  protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
  protected static ?string $navigationLabel = 'Manajemen Kegiatan';
  protected static ?string $pluralModelLabel = 'Manajemen Kegiatan';
  protected static ?string $label = "Manajemen Kegiatan";
  protected static ?int $navigationSort = 4;


  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Section::make('Informasi Kegiatan')
          ->schema([
            TextInput::make('activity_name')
              ->label('Nama Kegiatan')
              ->required()
              ->placeholder('Masukkan nama kegiatan'),
            Textarea::make('description')
              ->label('Deskripsi')
              ->placeholder('Masukkan deskripsi kegiatan'),
            DatePicker::make('activity_date')
              ->label('Tanggal Kegiatan')
              ->required()
              ->placeholder('Masukkan tanggal kegiatan'),
          ])
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('activity_name')
          ->label('Nama Kegiatan')
          ->searchable()
          ->copyable()
          ->sortable('activity_name'),
        TextColumn::make('description')
          ->label('Deskripsi')
          ->searchable()
          ->copyable()
          ->limit(50)
          ->sortable('description'),
        TextColumn::make('activity_date')
          ->label('Tanggal Kegiatan')
          ->searchable()
          ->copyable()
          ->sortable('activity_date'),
      ])
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

  public static function getRelations(): array
  {
    return [
      //
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListActivities::route('/'),
      'create' => Pages\CreateActivity::route('/create'),
      'edit' => Pages\EditActivity::route('/{record}/edit'),
    ];
  }
}
