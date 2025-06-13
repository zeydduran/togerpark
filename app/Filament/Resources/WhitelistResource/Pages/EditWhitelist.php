<?php

namespace App\Filament\Resources\WhitelistResource\Pages;

use App\Filament\Resources\WhitelistResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWhitelist extends EditRecord
{
    protected static string $resource = WhitelistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
