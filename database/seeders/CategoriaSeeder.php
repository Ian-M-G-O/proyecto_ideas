<?php
namespace Database\Seeders;
use App\Models\Categoria;
use Illuminate\Database\Seeder;
class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        Categoria::firstOrCreate([
            'nombre' => 'Tecnología',
            'descripcion' => 'Ideas relacionadas con tecnología y
            software.'
        ]);

        Categoria::firstOrCreate([
            'nombre' => 'Educación',
            'descripcion' => 'Ideas relacionadas con educación y
            aprendizaje.'
        ]);

        Categoria::firstOrCreate([
            'nombre' => 'Salud',
            'descripcion' => 'Ideas relacionadas con salud y
            bienestar.'
        ]);

        Categoria::firstOrCreate([
            'nombre' => 'Medio ambiente',
            'descripcion' => 'Ideas relacionadas con el cuidado
            del medio ambiente.'
        ]);
        Categoria::firstOrCreate([
             'nombre' => 'Deportes',
            'descripcion' => 'Ideas relacionadas con 
            actividades deportivas'
        ]);
    }
}
