<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use App\Filament\Resources\TeacherResource\RelationManagers;
use App\Filament\Resources\TeacherResource\Widgets\TeacherOverview;
use App\Models\Teacher;
use App\Models\User;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeacherResource extends Resource
{
  protected static ?string $model = Teacher::class;

  protected static ?string $navigationIcon = 'heroicon-o-user';
  protected static ?string $navigationLabel = 'Data Guru';
  protected static ?string $pluralModelLabel = 'Data Guru';
  protected static ?int $navigationSort = 1;

  public static function shouldRegisterNavigation(): bool
  {
    return false;
  }

  public static function getNavigationItems(): array
  {
    return [];
  }

  public static function getEloquentQuery(): Builder
  {
    return parent::getEloquentQuery()
      ->with(['user'])
      ->whereHas('user', function ($query) {
        $query->where('role_id', 2);
      });
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Select::make('id_users')
          ->label('Nama')
          ->options(
            User::where('role_id', 2)->whereNotIn('id', Teacher::pluck('id_users'))->pluck('name', 'id')
          )
          ->required()
          ->searchable()
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('user.name')->label('Nama Guru')->searchable()->sortable(),
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
      'index' => Pages\ListTeachers::route('/'),
      'create' => Pages\CreateTeacher::route('/create'),
      'edit' => Pages\EditTeacher::route('/{record}/edit'),
    ];
  }

  public static function getWidgets(): array
  {
    return [
      TeacherOverview::class
    ];
  }
}
