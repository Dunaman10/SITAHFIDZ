<?php

namespace App\Filament\Resources\MentorStudentResource\Pages;

use App\Filament\Resources\MentorStudentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMentorStudent extends EditRecord
{
    protected static string $resource = MentorStudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
