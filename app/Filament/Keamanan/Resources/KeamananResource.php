<?php

namespace App\Filament\Keamanan\Resources;

use App\Filament\Exports\PermissionExporter;
use App\Filament\Keamanan\Resources\KeamananResource\Pages;
use App\Models\Permission;
use Filament\Actions\ExportAction;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KeamananResource extends Resource
{
  protected static ?string $model = Permission::class;
  protected static ?string $navigationIcon = 'heroicon-o-shield-check';
  protected static ?string $navigationLabel = 'Perizinan';
  protected static ?string $pluralModelLabel = 'Perizinan Santri';
  protected static ?string $label = "Perizinan";

  public static function getEloquentQuery(): Builder
  {
    return parent::getEloquentQuery()
      ->with(['student']);
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Section::make('Informasi Perizinan')
          ->schema([
            TextInput::make('student_name')
              ->default(fn($record) => $record?->student?->student_name)
              ->label('Nama Santri')
              ->required()
              ->disabled(),
            TextInput::make('reason')
              ->label('Alasan')
              ->required()
              ->disabled(),
            TextInput::make('date_out')
              ->label('Tanggal Keluar')
              ->required()
              ->type('date')
              ->disabled(),
            TextInput::make('date_in')
              ->label('Tanggal Kembali')
              ->required()
              ->type('date')
              ->disabled(),

            Select::make('status')
              ->label('Status')
              ->options([
                'approved' => 'Approved',
                'rejected' => 'Rejected',
                'pending' => 'Pending',
              ])
              ->required(),
            TextInput::make('approved_by')
              ->label('Diterima/Ditolak Oleh')
              ->required(),
          ]),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('student.student_name')->label('Nama Santri')->searchable(),
        TextColumn::make('reason')->label('Alasan')->searchable(),
        TextColumn::make('date_out')->label('Tanggal Keluar')->date(),
        TextColumn::make('date_in')->label('Tanggal Kembali')->date(),
        TextColumn::make('status')
          ->label('Status')
          ->badge()
          ->color(
            fn(TextColumn $column) =>
            match ($column->getState()) {
              'approved' => 'success',
              'rejected' => 'danger',
              'pending' => 'warning',
              default => null,
            }
          ),
        TextColumn::make('approved_by')->label('Diterima/Ditolak Oleh')->searchable(),
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

  public static function getRelations(): array
  {
    return [
      //
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListKeamanans::route('/'),
      'create' => Pages\CreateKeamanan::route('/create'),
      'edit' => Pages\EditKeamanan::route('/{record}/edit'),
    ];
  }
}
