<?php

namespace App\Filament\Teacher\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Student;
use Filament\Forms\Form;
use App\Models\DataKelas;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;

use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Teacher\Resources\DataKelasResource\Pages;
use App\Filament\Teacher\Resources\DataKelasResource\RelationManagers;
use App\Models\Classes;

class DataKelasResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Data Kelas';
    protected static ?string $pluralModelLabel = 'Data Kelas';

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
                ImageColumn::make('profile')
                  ->label('Foto Santri')
                    ->circular()
                    ->size(50)
                    ->disk('public')
                   ,
               
                    
                TextColumn::make('student_name')
                    ->label('Nama Santri')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->formatStateUsing(fn ($state) => Carbon::parse($state)->translatedFormat('d F Y')),
                TextColumn::make('class.class_name')
                    ->label('Kelas')
                    ->searchable()


                    
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('class_id')
                    ->label('Pilih Kelas')
                    ->options(Classes::all()->pluck('class_name', 'id'))
           
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->modalHeading(fn (Model $record) => 'Biodata ' . $record->student_name),
            ]);
            // ->bulkActions([
            //     Tables\Actions\BulkActionGroup::make([
            //     Tables\Actions\DeleteBulkAction::make(),
            //     ]),
            // ]);
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
            'index' => Pages\ListDataKelas::route('/'),
            // 'create' => Pages\CreateDataKelas::route('/create'),
            // 'edit' => Pages\EditDataKelas::route('/{record}/edit'),
            
        ];
    }

 


public static function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->schema([
            Grid::make(['default' => 1, 'sm' => 1, 'md' => 1])
                
                ->schema([
                    ImageEntry::make('profile')
                        ->disk('public')
                        ->size(150)
                        ->circular()
                        ->extraAttributes(['class' => 'flex justify-center']),
                    
                    Section::make()
                        ->schema([
                            TextEntry::make('student_name')
                                ->label('Nama Santri')
                                
                                ->weight(FontWeight::Bold),

                            TextEntry::make('tanggal_lahir')
                                ->label('Tanggal Lahir')
                                ->weight(FontWeight::Bold)
                                ->formatStateUsing(fn ($state) =>Carbon::parse($state)->translatedFormat('d F Y')),

                            TextEntry::make('class.class_name')
                                ->label('Kelas')
                                ->weight(FontWeight::Bold),
                        ]),
                ]),
        ]);
}

}
