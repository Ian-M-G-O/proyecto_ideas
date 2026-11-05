<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Idea;
use App\Models\Categoria;

class IdeasGrafica extends ChartWidget
{
    protected static ?string $heading = 'Ideas Gráfica';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $registradas = Idea::where('estado', 'registrada')->count();
        $revision = Idea::where('estado', 'en revision')->count(); 
        $aprobadas = Idea::where('estado', 'aprobada')->count();
        $rechazadas = Idea::where('estado', 'rechazada')->count();

        
        $categoriasCount = Categoria::count();

        return [
            'datasets' => [
                [
                    'label' => 'Cantidad de Ideas',
                    'data' => [$registradas, $revision, $aprobadas, $rechazadas],
                    'backgroundColor' => '#3bcef6',
                ],
            ],
            'labels' => ['Registrada', 'En revisión', 'Aprobada', 'Rechazada'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}