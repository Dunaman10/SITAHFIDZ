<?php

namespace App\Filament\Parent\Resources;

use App\Filament\Parent\Resources\KegiatanResource\Pages;
use App\Filament\Parent\Resources\KegiatanResource\RelationManagers;
use App\Models\Activity;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KegiatanResource extends Resource
{
  protected static ?string $model = Activity::class;

  protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
  protected static ?string $navigationLabel = 'Kegiatan';
  protected static ?string $pluralModelLabel = 'Daftar Kegiatan Pondok Pesantren';
  protected static ?string $label = "Kegiatan";

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Section::make('Informasi Kegiatan')
          ->schema([
            TextInput::make('activity_name')
              ->label('Nama Kegiatan'),

            Textarea::make('description')
              ->label('Deskripsi')
              ->placeholder('Tidak ada deskripsi kegiatan'),

            TextInput::make('keterangan')
              ->label('Keterangan')
              ->placeholder('Tidak ada keterangan'),

            DatePicker::make('activity_date')
              ->label('Tanggal Kegiatan')
              ->placeholder('Tidak ada tanggal'),
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

        TextColumn::make('keterangan')
          ->label('Keterangan')
          ->searchable(),

        TextColumn::make('activity_date')
          ->label('Tanggal Kegiatan')
          ->date()
          ->sortable(),
      ])
      ->filters([
        //
      ])
      ->actions([
        // Tables\Actions\EditAction::make(),
        Tables\Actions\ViewAction::make()
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          // Tables\Actions\DeleteBulkAction::make(),
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
      'index' => Pages\ListKegiatans::route('/'),
      // 'create' => Pages\CreateKegiatan::route('/create'),
      // 'edit' => Pages\EditKegiatan::route('/{record}/edit'),
    ];
  }
}
