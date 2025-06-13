<?php

namespace App\Filament\Resources\HgsResource\Pages;

use App\Filament\Resources\HgsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHgs extends EditRecord
{
    protected static string $resource = HgsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
