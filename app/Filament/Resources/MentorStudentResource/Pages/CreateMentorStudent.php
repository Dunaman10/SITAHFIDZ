<?php

namespace App\Filament\Resources\MentorStudentResource\Pages;

use App\Filament\Resources\MentorStudentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMentorStudent extends CreateRecord
{
  protected static string $resource = MentorStudentResource::class;

  protected function getRedirectUrl(): string
  {
    return MentorStudentResource::getUrl('index');
  }
}
