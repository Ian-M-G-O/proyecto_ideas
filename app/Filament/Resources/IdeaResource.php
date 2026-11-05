<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IdeaResource\Pages;
use App\Models\Idea;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Helpers\EstadoIdea;

use Filament\Forms\Get;

use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;

use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;

class IdeaResource extends Resource
{
    protected static ?string $model = Idea::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('titulo')
                    ->label('Titulo de la idea')
                    ->helperText('Escribe un titulo que sea ilustrativo y breve')
                    ->placeholder('Ej Aplicación de comida')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->validationMessages([
                        'unique' => 'Ya existe una idea registrada con ese título.',
                    ]),
                Forms\Components\Textarea::make('descripcion')
                    ->label('Describe tu idea')
                    ->helperText('Describe a detalle en que consiste la idea del proyecto')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('autor')
                    ->label('Autor')
                    ->required(),
                Forms\Components\Select::make('categoria_id')
                    ->label('Categoría')
                    ->relationship('categoria', 'nombre')
                    ->required(),

                // Solo admin y coordinador pueden modificar el estado
                Forms\Components\Select::make('estado')
                    ->label('Estado')
                    ->required()
                    ->options(EstadoIdea::opciones())
                    ->default('registrada')
                    ->hiddenOn('create')
                    ->disabled(fn () => ! in_array(auth()->user()->rol, ['admin', 'coordinador']))
                    ->live(),

                Forms\Components\Textarea::make('observacion')
                    ->label('Motivo de rechazo')
                    ->placeholder('Escribe la razón...')
                    ->maxLength(200)
                    ->required()
                    ->columnSpanFull()
                    ->disabled(fn () => ! in_array(auth()->user()->rol, ['admin', 'coordinador']))
                    ->visible(fn (Get $get) => $get('estado') === 'rechazada'),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Detalle de la Idea')
                    ->description('Información completa sobre la propuesta registrada.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('titulo')
                                    ->label('Título de la idea')
                                    ->weight('bold')
                                    ->columnSpanFull(),

                                TextEntry::make('descripcion')
                                    ->label('Descripción')
                                    ->columnSpanFull(),

                                TextEntry::make('autor')
                                    ->label('Autor')
                                    ->icon('heroicon-m-user'),

                                TextEntry::make('categoria.nombre')
                                    ->label('Categoría')
                                    ->badge()
                                    ->color('info'),

                                TextEntry::make('estado')
                                    ->label('Estado')
                                    ->badge()
                                    ->color(fn (?string $state): string => match (mb_strtolower((string) $state)) {
                                        'registrada' => 'warning',
                                        'en revision' => 'info',
                                        'aprobada' => 'success',
                                        'rechazada' => 'danger',
                                        default => 'gray',
                                    }),

                                TextEntry::make('observacion')
                                    ->label('Motivo del rechazo')
                                    ->color('danger')
                                    ->columnSpanFull()
                                    ->visible(fn (Idea $record) => $record->estado === 'rechazada'),

                                TextEntry::make('created_at')
                                    ->label('Fecha de creación')
                                    ->dateTime('d/m/Y H:i'),

                                TextEntry::make('updated_at')
                                    ->label('Última actualización')
                                    ->dateTime('d/m/Y H:i'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('titulo')
                    ->label('Idea')
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->wrap()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('observacion')
                    ->label('Observación')
                    ->wrap()
                    ->searchable()
                    ->placeholder('—')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('autor')
                    ->label('Autor')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('categoria.nombre')
                    ->label('Categoría')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado el')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado el')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        'registrada' => 'Registrada',
                        'en revision' => 'En revisión',
                        'aprobada' => 'Aprobada',
                        'rechazada' => 'Rechazada',
                    ]),
                TrashedFilter::make(),
            ])
            ->actions([
                // Usan la policy automáticamente (update, view, delete, restore, forceDelete)
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),

                // Personalizadas: solo admin y coordinador (cambiarEstado)
                Action::make('aprobar')
                    ->label('Aprobar')
                    ->color('success')
                    ->icon('heroicon-m-hand-thumb-up')
                    ->requiresConfirmation()
                    ->modalHeading('Aprobación')
                    ->modalDescription('¿Deseas aprobar esa idea?')
                    ->action(function (Idea $record) {
                        $record->update([
                            'estado' => 'aprobada',
                            'observacion' => null,
                        ]);

                        Notification::make()
                            ->title('Idea aprobada correctamente')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Idea $record) =>
                        auth()->user()->can('cambiarEstado', $record)
                        && $record->estado !== 'aprobada'),

                Action::make('rechazar')
                    ->label('Rechazar')
                    ->color('danger')
                    ->icon('heroicon-m-hand-thumb-down')
                    ->form([
                        Forms\Components\Textarea::make('observacion')
                            ->label('Motivo del rechazo')
                            ->placeholder('Escribe la razón por la cual se rechaza la idea...')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->action(function (Idea $record, array $data) {
                        $record->update([
                            'estado' => 'rechazada',
                            'observacion' => $data['observacion'],
                        ]);

                        Notification::make()
                            ->title('Idea rechazada correctamente')
                            ->danger()
                            ->send();
                    })
                    ->visible(fn (Idea $record) =>
                        auth()->user()->can('cambiarEstado', $record)
                        && $record->estado !== 'rechazada'),
            ])
            ->recordUrl(null)
            ->recordAction(null);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIdeas::route('/'),
            'create' => Pages\CreateIdea::route('/create'),
            'view' => Pages\IdeaInfolist::route('/{record}'),
            'edit' => Pages\EditIdea::route('/{record}/edit'),
        ];
    }
}