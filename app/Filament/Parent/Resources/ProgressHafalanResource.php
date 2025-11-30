<?php

namespace App\Filament\Parent\Resources;

use App\Filament\Parent\Resources\ProgressHafalanResource\Pages;
use App\Models\Memorize;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
      ->defaultSort('created_at', 'desc')
      ->columns([
        TextColumn::make('student.student_name')
          ->label('Nama Santri')
          ->sortable()
          ->searchable(query: function (Builder $query, string $search): Builder {
            return $query->whereHas(
              'student',
              fn($q) =>
              $q->where('student_name', 'like', "%{$search}%")
            );
          }),

        TextColumn::make('surah.surah_name')
          ->label('Surah')
          ->searchable(query: function (Builder $query, string $search): Builder {
            return $query->whereHas(
              'surah',
              fn($q) =>
              $q->where('surah_name', 'like', "%{$search}%")
            );
          }),

        TextColumn::make('surah.juz')
          ->label('Juz')
          ->alignCenter(),

        TextColumn::make('nilai_avg')
          ->label('Nilai Rata-Rata')
          ->alignCenter(),

        TextColumn::make('approved_by')
          ->label('Dinilai Oleh'),

        TextColumn::make('created_at')
          ->label('Tanggal')
          ->date('d M Y'),

      ])

      ->filters([
        //
      ])
      ->actions([
        ViewAction::make()
          ->label('Lihat Detail')
          ->modalHeading('Detail Hafalan Santri')
          ->modalWidth('lg')
          ->modalSubmitAction(false)
          ->form([
            TextInput::make('student_name')
              ->label('Nama Santri')
              ->disabled()
              ->formatStateUsing(fn($record) => $record?->student?->student_name),

            TextInput::make('surah_name')
              ->label('Surah')
              ->disabled()
              ->formatStateUsing(fn($record) => $record?->surah?->surah_name),

            TextInput::make('from')
              ->label('Dari Ayat')
              ->disabled(),

            TextInput::make('to')
              ->label('Sampai Ayat')
              ->disabled(),

            TextInput::make('nilai_avg')
              ->label('Nilai Rata-Rata')
              ->disabled(),

            TextInput::make('approved_by')
              ->label('Dinilai Oleh')
              ->disabled(),

            DatePicker::make('created_at')
              ->label('Tanggal')
              ->disabled(),

            FileUpload::make('audio')
              ->label('Rekaman Audio Hafalan')
              ->disabled()
              ->previewable(true)
              ->downloadable(),

            FileUpload::make('foto')
              ->label('Foto Santri')
              ->disabled()
              ->previewable(true)
              ->downloadable(),

            Section::make('Penilain Hafalan')
              ->description('Bagian ini berisi nilai dan kualitas bacaan santri')
              ->schema([
                TextInput::make('makharijul_huruf')
                  ->label('Makharijul Huruf'),

                TextInput::make('shifatul_huruf')
                  ->label('Shifatul Huruf'),

                TextInput::make('ahkamul_qiroat')
                  ->label('Akhkamul Qiroat'),

                TextInput::make('ahkamul_waqfi')
                  ->label('Akhkamul Waqfi'),

                TextInput::make('qowaid_tafsir')
                  ->label('Qowaid Tafsir'),

                TextInput::make('tarjamatul_ayat')
                  ->label('Tarjamatul Ayat'),
              ])
          ]),
      ])

      ->bulkActions([
        BulkActionGroup::make([
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
      'index' => Pages\ListProgressHafalans::route('/'),
    ];
  }
}
