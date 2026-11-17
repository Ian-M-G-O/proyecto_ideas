<?php

use App\Models\Categoria;
use App\Models\Idea;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// Ayudante para no repetir datos
function crearIdea(array $atributos = []): Idea
{
    $categoria = Categoria::create([
        'nombre'      => 'Tecnología',
        'descripcion' => 'Ideas relacionadas con tecnología',
    ]);

    return Idea::create(array_merge([
        'titulo'       => 'Idea de prueba',
        'descripcion'  => 'Descripción de la idea de prueba',
        'autor'        => 'Ian Miguel',
        'estado'       => 'pendiente',
        'categoria_id' => $categoria->id,
    ], $atributos));
}

// Modificar el estado de una idea
it('cambia el estado de una idea a en revisión', function () {
    $idea = crearIdea();

    $idea->update(['estado' => 'en revisión']);
    $idea->refresh();

    expect($idea->estado)->toBe('en revisión');
    expect($idea->titulo)->toBe('Idea de prueba');
    expect($idea->descripcion)->toBe('Descripción de la idea de prueba');
    expect($idea->autor)->toBe('Ian Miguel');
});

// Cambiar la categoría de una idea
it('reasigna una idea a otra categoría', function () {
    $idea = crearIdea();
    $categoriaOriginal = $idea->categoria_id;
    $nuevaCategoria = Categoria::create([
        'nombre'      => 'Educación',
        'descripcion' => 'Ideas relacionadas con educación',
    ]);

    $idea->update(['categoria_id' => $nuevaCategoria->id]);
    $idea->refresh();

    expect($idea->categoria_id)->toBe($nuevaCategoria->id);
    expect($idea->categoria_id)->not->toBe($categoriaOriginal);
    expect(Idea::where('categoria_id', $categoriaOriginal)->count())->toBe(0);
    expect(Idea::where('categoria_id', $nuevaCategoria->id)->count())->toBe(1);
});

// Eliminar lógicamente una idea
it('elimina lógicamente una idea', function () {
    $idea = crearIdea();

    $idea->delete();

    // No aparece en consultas normales
    expect(Idea::find($idea->id))->toBeNull();

    // Sigue en la BD con fecha de eliminación
    $this->assertSoftDeleted('ideas', ['id' => $idea->id]);
    $eliminada = Idea::withTrashed()->find($idea->id);
    expect($eliminada)->not->toBeNull();
    expect($eliminada->deleted_at)->not->toBeNull();
});

// Registrar una idea con una categoría inexistente
it('rechaza una idea con categoría inexistente', function () {
    $excepcion = false;

    try {
        Idea::create([
            'titulo'       => 'Idea inválida',
            'descripcion'  => 'Categoría que no existe',
            'autor'        => 'Ian Miguel',
            'estado'       => 'pendiente',
            'categoria_id' => 9999,
        ]);
    } catch (QueryException $e) {
        $excepcion = true;
    }

    expect($excepcion)->toBeTrue();
    $this->assertDatabaseMissing('ideas', ['categoria_id' => 9999]);
});
