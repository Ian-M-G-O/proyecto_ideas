<?php

namespace App\Filament\Resources\IdeaResource\Pages;

use App\Filament\Resources\IdeaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIdea extends CreateRecord
{
    protected static string $resource = IdeaResource::class;
    protected static ?string $title = 'Registrar nueva idea';
    protected static bool $canCreateAnother = false;


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getCreatedNotificationTitle(): ?string
    {
    return 'Categoria creada exitosamente';
    }
}
