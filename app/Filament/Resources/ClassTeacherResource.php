<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassTeacherResource\Pages;
use App\Filament\Resources\ClassTeacherResource\RelationManagers;
use App\Models\ClassTeacher;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClassTeacherResource extends Resource
{
  protected static ?string $model = ClassTeacher::class;

  protected static ?string $navigationIcon = 'heroicon-o-folder-open';
  protected static ?int $navigationSort = 4;
  protected static ?string $navigationLabel = 'Manajemen Kelas';
  protected static ?string $pluralModelLabel = 'Manajemen Kelas';

  public static function getEloquentQuery(): Builder
  {
    return parent::getEloquentQuery()
      ->with(['class', 'teacher.user']);
  }

  // Sembunyikan Resource dari sidebar
  public static function shouldRegisterNavigation(): bool
  {
    return false;
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Select::make('id_class')
          ->relationship('class', 'class_name')
          ->label('Kelas')
          ->required(),

        Select::make('id_teacher')
          ->label('Guru')
          ->searchable()
          ->preload()
          ->selectablePlaceholder(false)
          ->options(function () {
            return \App\Models\Teacher::with('user')
              ->whereHas('user', function ($query) {
                $query->where('role_id', 2);
              })
              ->get()
              ->mapWithKeys(function ($teacher) {
                return [$teacher->id => $teacher->user->name];
              });
          })
          ->required(),

      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('class.class_name')
          ->label('Kelas')
          ->searchable(),
        TextColumn::make('teacher.user.name')
          ->label('Guru')
          ->searchable(),
      ])
      ->filters([
        //
      ])
      ->actions([
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
      'index' => Pages\ListClassTeachers::route('/'),
      'create' => Pages\CreateClassTeacher::route('/create'),
      'edit' => Pages\EditClassTeacher::route('/{record}/edit'),
    ];
  }
}
