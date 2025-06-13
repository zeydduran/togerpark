<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public function getBreadcrumb(): string
    {
        return 'Kullanıcı Ekle';
    }

    public function getTitle(): string
    {
        return 'Kullanıcı Ekle';
    }

    public function getDescription(): string
    {
        return 'Kullanıcı ekleme sayfası';
    }

    public function getHeading(): string
    {
        return 'Kullanıcı Ekle';
    }

    public function getCreateFormAction(): Action
    {
        return Action::make('create')
            ->label('Kullanıcı Ekle')
            ->icon('heroicon-o-user-plus')
            ->color('success');
    }

    public function getCreateAnotherFormAction(): Action
    {
        return Action::make('createAnother')
            ->label('Kaydet ve Başka Kullanıcı Ekle')
            ->icon('heroicon-o-user-plus')
            ->color('success');
    }

    public function getCancelFormAction(): Action
    {
        return Action::make('cancel')
            ->label('İptal')
            ->icon('heroicon-o-x-mark')
            ->color('danger');
    }
}
