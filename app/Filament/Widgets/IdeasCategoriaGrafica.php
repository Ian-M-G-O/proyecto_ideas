<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Idea;
use App\Models\Categoria;

class IdeasCategoriaGrafica extends ChartWidget
{
    protected static ?string $heading = 'Ideas por Categoría';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        
        $categorias = Categoria::withCount('ideas')->get();

        $labels = $categorias->pluck('nombre')->toArray();
        $data = $categorias->pluck('ideas_count')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Ideas por Categoría',
                    'data' => $data,
                    'backgroundColor' => ['#f6863b','#d6cc15','#91e949','#81f3ea','#5cacf6','#b548ec',
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}