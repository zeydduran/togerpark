<?php

namespace App\Filament\Resources\ParkSessionResource\Pages;

use App\Filament\Resources\ParkSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParkSessions extends ListRecords
{
    protected static string $resource = ParkSessionResource::class;


    public function getBreadcrumb(): string
    {
        return 'Liste';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Otopark Girişi Ekle')
                ->icon('heroicon-o-truck'),
        ];
    }
    public function getTitle(): string
    {
        return 'Otopark Girişleri';
    }

    public function getDescription(): string
    {
        return 'Otopark girişlerini görüntüleyin ve yönetin.';
    }

    public function getHeading(): string
    {
        return 'Otopark Girişleri';
    }

    public function getSubheading(): string
    {
        return 'Otopark girişlerini görüntüleyin ve yönetin.';
    }
    public function getHeadingIcon(): string
    {
        return 'heroicon-o-truck';
    }

    public function getHeadingIconColor(): string
    {
        return 'primary';
    }
    public function getHeadingIconSize(): string
    {
        return 'lg';
    }
    public function getHeadingIconAlignment(): string
    {
        return 'left';
    }

}
