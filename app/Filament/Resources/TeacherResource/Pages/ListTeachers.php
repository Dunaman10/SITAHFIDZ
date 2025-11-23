<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Filament\Resources\TeacherResource;
use App\Filament\Resources\TeacherResource\Widgets\TeacherOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeachers extends ListRecords
{
  protected static string $resource = TeacherResource::class;

  // protected function getHeaderActions(): array
  // {
  //   return [
  //     Actions\CreateAction::make('create')
  //       ->label('Tambah Guru')
  //       ->outlined()
  //       ->color('gray'),
  //   ];
  // }

  protected function getHeaderWidgets(): array
  {
    return [
      TeacherOverview::class
    ];
  }
}
