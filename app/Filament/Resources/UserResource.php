<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\Widgets\UserOverview;
use App\Filament\Resources\UserResource\Widgets\UsersOverview;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use PhpParser\Node\Stmt\Static_;

class UserResource extends Resource
{
  protected static ?string $model = User::class;
  protected static ?string $navigationIcon = 'heroicon-o-users';
  protected static ?string $navigationLabel = 'Data Pengguna';
  protected static ?string $pluralModelLabel = 'Data Pengguna';
  protected static ?int $navigationSort = 4;

  public static function getEloquentQuery(): Builder
  {
    return parent::getEloquentQuery()
      ->with(['role']);
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        TextInput::make('name')->required(),
        TextInput::make('email')->required()->email()->unique(ignoreRecord: true),
        TextInput::make('password')->required()->password()->revealable(),
        Select::make('role_id')
          ->label('Role')
          ->options(
            \App\Models\Role::whereIn('role_name', ['admin', 'orang_tua'])
              ->get()
              ->pluck(function ($role) {
                return match ($role->role_name) {
                  'admin' => 'Admin',
                  'orang_tua' => 'Orang Tua',
                  default => ucfirst($role->role_name),
                };
              }, 'id')
          )
          ->required()

      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->query(User::with('role'))
      ->columns([
        TextColumn::make('name')->searchable()->sortable(),
        TextColumn::make('email')->searchable(),
        TextColumn::make('role.role_name')->label('Role')->searchable(),
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
      'index' => Pages\ListUsers::route('/'),
      'create' => Pages\CreateUser::route('/create'),
      'edit' => Pages\EditUser::route('/{record}/edit'),
    ];
  }

  public static function getWidgets(): array
  {
    return [
      UserOverview::class
    ];
  }
}
