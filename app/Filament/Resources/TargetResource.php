<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TargetResource\Pages;
use App\Filament\Resources\TargetResource\RelationManagers;
use App\Models\Classes;
use App\Models\Target;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Date;

class TargetResource extends Resource
{
  protected static ?string $model = Target::class;

  protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-up';
  protected static ?string $label = "Manejemen Target";
  protected static ?string $pluralModelLabel = 'Manejemen Target';
  protected static ?int $navigationSort = 4;

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        TextInput::make('count_target')
          ->label('Target / ayat')
          ->required()
          ->placeholder('Masukkan data target'),
        Select::make("id_class")
          ->label('Kelas')
          ->required()
          ->options(Classes::all()->pluck("class_name", "id")),
        TextInput::make("date_target")
          ->label("Waktu Target (Minggu)")
          ->required()
          ->placeholder("Masukan waktu target")
          ->maxValue(53),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('count_target')
          ->label('Target / ayat')
          ->searchable()
          ->copyable()
          ->sortable('count_target'),

        Tables\Columns\TextColumn::make('class.class_name')
          ->label('Kelas')
          ->searchable()
          ->copyable()
          ->sortable('class.class_name'),

        Tables\Columns\TextColumn::make('date_target')
          ->label('Waktu Target')
          ->formatStateUsing(fn($state) => "{$state} minggu")
          ->searchable()
          ->copyable(),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\ViewAction::make(),
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
      'index' => Pages\ListTargets::route('/'),
      'create' => Pages\CreateTarget::route('/create'),
      'edit' => Pages\EditTarget::route('/{record}/edit'),
    ];
  }
}
