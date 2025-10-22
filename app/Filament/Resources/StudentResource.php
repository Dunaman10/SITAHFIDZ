<?php

namespace App\Filament\Resources;

use Carbon\Carbon;

use App\Models\User;
use Filament\Tables;
use App\Models\Classes;
use App\Models\Student;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\StudentResource\Pages;

class StudentResource extends Resource
{
  protected static ?string $model = Student::class;
  protected static ?string $navigationIcon = 'heroicon-o-user-group';
  protected static ?string $navigationLabel = 'Data Santri';
  protected static ?string $pluralModelLabel = 'Data Santri';
  protected static ?int $navigationSort = 2;

  public static function getEloquentQuery(): Builder
  {
    return parent::getEloquentQuery()
      ->with(['user', 'class']);
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        TextInput::make('student_name')
          ->label('Nama Santri')
          ->required()
          ->placeholder('Masukkan nama santri')
          ->maxLength(255)
          ->columnSpanFull(),

        ///orangtua
        Select::make('parent')
          ->label('Orang Tua')
          ->relationship('user', 'name')
          ->required()
          ->placeholder('Pilih orang tua')
          ->options(User::where('role_id', '3')->pluck('name', 'id')),


        Select::make('class_id')
          ->label('Kelas')
          ->placeholder('Pilih kelas')
          ->options(Classes::all()->pluck('class_name', 'id'))
          ->required(),

        FileUpload::make('profile')
          ->label('Profil')
          ->image()
          ->disk('public')
          ->directory('profile')
          ->visibility('public')
          ->imageEditor(),

        DatePicker::make('tanggal_lahir')
          ->label('Tanggal Lahir')
          ->required()
          ->placeholder('Pilih tanggal lahir')
          ->default(now()),

      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([

        ImageColumn::make('profile')
          ->label('Foto Profil')
          ->disk('public') // Sesuaikan dengan disk tempat file disimpan
          ->circular(),

        TextColumn::make('student_name')
          ->label('Nama Santri')
          ->searchable()
          ->copyable()
          ->sortable('student_name'),

        TextColumn::make('user.name')
          ->label('Nama Orang Tua')
          ->searchable()
          ->copyable()
          ->sortable('user.name'),

        TextColumn::make('class.class_name')
          ->label('Kelas')
          ->searchable()
          ->copyable()
          ->sortable('class.class_name'),

        TextColumn::make('tanggal_lahir')
          ->label('Tanggal Lahir')
          ->formatStateUsing(fn($state) => Carbon::parse($state)->translatedFormat('d F Y')),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\ViewAction::make(),
        Tables\Actions\DeleteAction::make()
          ->modalHeading(fn($record) => 'Hapus Santri ' . $record->student_name) // <-- Closure di sini, menerima $record
          ->modalDescription('Apakah Anda yakin ingin menghapus santri ini?')
          ->modalcancelActionLabel('Batalkan')
          ->modalSubmitActionLabel('ya, Hapus')


          //Notifikasi sukses setelah penghapusan
          ->successNotification(
            fn($record) => Notification::make()
              ->title('Santri berhasil dihapus')
              ->body('Santri ' . $record->student_name . ' telah berhasil dihapus.')
              ->icon('heroicon-o-trash') // Ikon sampah
              ->iconColor('danger') // Warna ikon
              ->success() // Tipe notifikasi sukses
              ->duration(5000) // Durasi tampil
          )

      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),

      ])

      ->emptyStateHeading('Belum ada data santri');
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
      'index' => Pages\ListStudents::route('/'),
      'create' => Pages\CreateStudent::route('/create'),
      'edit' => Pages\EditStudent::route('/{record}/edit'),
    ];
  }

  protected function getDeletedNotification(): ?Notification
  {
    return null;
  }

  // Pastikan ini ada dan mengembalikan NULL (untuk bulk delete)
  protected function getBulkDeletedNotification(): ?Notification
  {
    return null;
  }
}
