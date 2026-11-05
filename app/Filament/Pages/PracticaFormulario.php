<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;

class PracticaFormulario extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.pages.practica-formulario';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'activo' => true,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Nombre de las Alumnas: Espina Quezada Mayra Itzel Guadalupe, López Vázquez Katerine Daniella ') 
                    ->schema([
                        TextInput::make('nombre')
                            ->label('Nombre del proyecto')
                            ->required(),

                        Select::make('temas')
                            ->label('Temas')
                            ->options([
                                'Tecnología' => 'Tecnología',
                                'Educación' => 'Educación',
                                'Salud' => 'Salud',
                                'Medio ambiente' => 'Medio ambiente',
                                'Entretenimiento' => 'Entretenimiento',
                            ])
                            ->required(),

                        Radio::make('prioridad')
                            ->label('Prioridad')
                            ->options([
                                'Baja' => 'Baja',
                                'Media' => 'Media',
                                'Alta' => 'Alta',
                            ]),

                        Toggle::make('activo')
                            ->label('Proyecto activo')
                            ->default(true),

                        DatePicker::make('fecha_entrega')
                            ->label('Fecha de entrega')
                            ->required(),
                    ]),
            ])
            ->statePath('data');
    }

    public function guardar(): void
    {
        $datos = $this->form->getState();
    }
}