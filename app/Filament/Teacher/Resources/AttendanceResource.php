<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\AttendanceResource\Pages;
use App\Models\Attendance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceResource extends Resource
{
  protected static ?string $model = Attendance::class;

  protected static ?string $navigationLabel = 'Kehadiran';
  protected static ?string $pluralModelLabel = 'Kehadiran Santri';
  protected static ?string $label = "Kehadiran";
  protected static ?string $navigationIcon = 'heroicon-o-clipboard';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        //
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('student.student_name')
          ->label('Nama Santri')
          ->searchable(),

        TextColumn::make('classes.class_name')
          ->label('Kelas'),

        TextColumn::make('date')
          ->label('Tanggal')
          ->date(),

        // Edit status langsung di table
        SelectColumn::make('status')
          ->label('Ubah Status')
          ->options([
            'hadir' => 'Hadir',
            'sakit' => 'Sakit',
            'tidak_hadir' => 'Tidak Hadir',
            'izin_pulang' => 'Izin Pulang',
          ]),
      ])
      ->filters([
        SelectFilter::make('id_class')
          ->relationship('classes', 'class_name'),
        Filter::make('date')
          ->form([
            Forms\Components\DatePicker::make('tanggal'),
          ])
          ->query(
            fn($query, $data) =>
            $query->when(
              $data['tanggal'] ?? null,
              fn($q) => $q->whereDate('date', $data['tanggal'])
            )
          ),

      ])
      ->actions([
        //
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
      'index' => Pages\ListAttendances::route('/'),
      'create' => Pages\CreateAttendance::route('/create'),
      // 'edit' => Pages\EditAttendance::route('/{record}/edit'),
    ];
  }
}
