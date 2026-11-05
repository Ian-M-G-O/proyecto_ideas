<?php

namespace App\Filament\Resources\CategoriaResource\Pages;

use App\Filament\Resources\CategoriaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCategoria extends CreateRecord
{
    
    protected static string $resource = CategoriaResource::class;
     protected static ?string $title = 'Registrar nueva categoria';
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
