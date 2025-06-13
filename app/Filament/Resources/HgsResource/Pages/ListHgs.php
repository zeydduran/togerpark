<?php

namespace App\Filament\Resources\HgsResource\Pages;

use App\Filament\Resources\HgsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHgs extends ListRecords
{
    protected static string $resource = HgsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
