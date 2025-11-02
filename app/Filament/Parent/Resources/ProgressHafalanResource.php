<?php

namespace App\Filament\Parent\Resources;

use App\Filament\Parent\Resources\ProgressHafalanResource\Pages;
use App\Filament\Parent\Resources\ProgressHafalanResource\RelationManagers;
use App\Models\Memorize;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProgressHafalanResource extends Resource
{
  protected static ?string $model = Memorize::class;

  protected static ?string $navigationIcon = 'heroicon-o-book-open';

  protected static ?string $navigationLabel = 'Progress Hafalan Anak Anda';
  protected static ?string $pluralModelLabel = 'Progress Hafalan Anak Anda';

  public static function getEloquentQuery(): Builder
  {
    $parent = auth()->user(); // user yang login (orang tua)

    return parent::getEloquentQuery()
      ->whereHas('student', function ($query) use ($parent) {
        $query->where('parent', $parent->id); // asumsi relasi student -> parent
      });
  }


  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('student.student_name')
          ->label('Nama Santri')
          ->sortable()
          ->searchable(),

        TextColumn::make('surah.surah_name')
          ->label('Surah'),

        TextColumn::make('from')
          ->label('Dari Ayat')
          ->alignCenter(),

        TextColumn::make('to')
          ->label('Sampai Ayat')
          ->alignCenter(),

        TextColumn::make('created_at')
          ->label('Tanggal')
          ->dateTime('d M Y'),

      ])

      ->filters([
        //
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          // Tables\Actions\ViewAction::make(),
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
      'index' => Pages\ListProgressHafalans::route('/'),
    ];
  }
}
