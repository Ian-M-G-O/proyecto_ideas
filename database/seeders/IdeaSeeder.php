<?php

namespace Database\Seeders;

use App\Models\Idea;
use App\Models\Categoria;
use Illuminate\Database\Seeder;

class IdeaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Deportes
        $deportes = Categoria::where('nombre', 'Deportes')->first();
        if ($deportes) {
            Idea::firstOrCreate(['titulo' => 'Organizador de Torneos Locales'], [
                'descripcion' => 'Aplicación para gestionar partidos y torneos.',
                'estado' => 'aprobada',
                'autor' => 'Mayra',
                'categoria_id' => $deportes->id
            ]);
            Idea::firstOrCreate(['titulo' => 'Control de ligas de fútbol amateur'], [
                'descripcion' => 'App para registrar estadísticas, goles y tarjetas.',
                'estado' => 'registrada',
                'autor' => 'Luis',
                'categoria_id' => $deportes->id
            ]);
            Idea::firstOrCreate(['titulo' => 'App de rutinas de entrenamiento físico'], [
                'descripcion' => 'Plataforma con ejercicios personalizados para casa y gimnasio.',
                'estado' => 'en revision',
                'autor' => 'Carlos',
                'categoria_id' => $deportes->id
            ]);
        }

        // 2. Educación
        $educacion = Categoria::where('nombre', 'Educación')->first();
        if ($educacion) {
            Idea::firstOrCreate(['titulo' => 'Plataforma para cursos en línea'], [
                'descripcion' => 'Sistema para ofrecer cursos y materiales educativos.',
                'estado' => 'en revision',
                'autor' => 'Pedro',
                'categoria_id' => $educacion->id
            ]);
            Idea::firstOrCreate(['titulo' => 'Asesorías escolares virtuales'], [
                'descripcion' => 'Espacio para conectar alumnos con profesores particulares.',
                'estado' => 'aprobada',
                'autor' => 'Carlos',
                'categoria_id' => $educacion->id
            ]);
            Idea::firstOrCreate(['titulo' => 'Sistema de control de asistencia escolar'], [
                'descripcion' => 'Herramienta para que los maestros pasen lista digitalmente.',
                'estado' => 'registrada',
                'autor' => 'Sofía',
                'categoria_id' => $educacion->id
            ]);
        }

        // 3. Español
        $espanol = Categoria::where('nombre', 'Español')->first();
        if ($espanol) {
            Idea::firstOrCreate(['titulo' => 'Taller de ortografía interactivo'], [
                'descripcion' => 'Juegos de reglas ortográficas para primaria.',
                'estado' => 'registrada',
                'autor' => 'Sofia',
                'categoria_id' => $espanol->id
            ]);
            Idea::firstOrCreate(['titulo' => 'Biblioteca digital de literatura clásica'], [
                'descripcion' => 'Repositorio de libros y resúmenes literarios.',
                'estado' => 'aprobada',
                'autor' => 'Daniel',
                'categoria_id' => $espanol->id
            ]);
            Idea::firstOrCreate(['titulo' => 'Generador de poemas y ensayos'], [
                'descripcion' => 'Asistente de redacción creativa en español.',
                'estado' => 'rechazada',
                'autor' => 'Elena',
                'categoria_id' => $espanol->id,
                'observacion' => 'El alcance del proyecto no está bien definido.'
            ]);
        }

        // 4. Matemáticas
        $matematicas = Categoria::where('nombre', 'Matemáticas')->first();
        if ($matematicas) {
            Idea::firstOrCreate(['titulo' => 'App de cálculo diferencial paso a paso'], [
                'descripcion' => 'Herramienta para resolver derivadas con explicación.',
                'estado' => 'aprobada',
                'autor' => 'Mayra',
                'categoria_id' => $matematicas->id
            ]);
            Idea::firstOrCreate(['titulo' => 'Juegos de álgebra básica'], [
                'descripcion' => 'Plataforma lúdica para practicar ecuaciones.',
                'estado' => 'en revision',
                'autor' => 'Jorge',
                'categoria_id' => $matematicas->id
            ]);
            Idea::firstOrCreate(['titulo' => 'Calculadora de matrices avanzadas'], [
                'descripcion' => 'Software para operaciones con matrices y determinantes.',
                'estado' => 'registrada',
                'autor' => 'Alex',
                'categoria_id' => $matematicas->id
            ]);
        }

        // 5. Medio ambiente
        $medioAmbiente = Categoria::where('nombre', 'Medio ambiente')->first();
        if ($medioAmbiente) {
            Idea::firstOrCreate(['titulo' => 'Mapa de centros de reciclaje'], [
                'descripcion' => 'Ubicación y tipos de residuos aceptados por zona.',
                'estado' => 'registrada',
                'autor' => 'Andrea',
                'categoria_id' => $medioAmbiente->id
            ]);
            Idea::firstOrCreate(['titulo' => 'Monitoreo de consumo de agua'], [
                'descripcion' => 'Sistema para calcular y reducir el gasto hídrico en hogares.',
                'estado' => 'aprobada',
                'autor' => 'Raúl',
                'categoria_id' => $medioAmbiente->id
            ]);
            Idea::firstOrCreate(['titulo' => 'Red de reporte de contaminación urbana'], [
                'descripcion' => 'App para reportar tiraderos clandestinos y baches.',
                'estado' => 'en revision',
                'autor' => 'Lucia',
                'categoria_id' => $medioAmbiente->id
            ]);
        }

        // 6. Salud
        $salud = Categoria::where('nombre', 'Salud')->first();
        if ($salud) {
            Idea::firstOrCreate(['titulo' => 'Aplicación para organizar citas veterinarias'], [
                'descripcion' => 'Sistema para registrar y organizar citas de mascotas.',
                'estado' => 'registrada',
                'autor' => 'Jose',
                'categoria_id' => $salud->id
            ]);
            Idea::firstOrCreate(['titulo' => 'Control de expedientes clínicos'], [
                'descripcion' => 'Plataforma para llevar el historial médico digital.',
                'estado' => 'rechazada',
                'autor' => 'Ana',
                'categoria_id' => $salud->id,
                'observacion' => 'Falta cumplir con la norma de protección de datos de salud.'
            ]);
            Idea::firstOrCreate(['titulo' => 'Recordatorio de toma de medicamentos'], [
                'descripcion' => 'Alarma inteligente para pacientes con tratamientos crónicos.',
                'estado' => 'aprobada',
                'autor' => 'Mario',
                'categoria_id' => $salud->id
            ]);
        }

        // 7. Tecnología
        $tecnologia = Categoria::where('nombre', 'Tecnología')->first();
        if ($tecnologia) {
            Idea::firstOrCreate(['titulo' => 'Sistema de inventario con Filament'], [
                'descripcion' => 'Control de entradas y salidas de almacén.',
                'estado' => 'aprobada',
                'autor' => 'Mayra',
                'categoria_id' => $tecnologia->id
            ]);
            Idea::firstOrCreate(['titulo' => 'Plataforma de gestión de tareas ágiles'], [
                'descripcion' => 'Tableros tipo Kanban para proyectos escolares.',
                'estado' => 'en revision',
                'autor' => 'Kevin',
                'categoria_id' => $tecnologia->id
            ]);
            Idea::firstOrCreate(['titulo' => 'Buscador de pasantes de programación'], [
                'descripcion' => 'Conecta estudiantes de FCA con empresas de software.',
                'estado' => 'registrada',
                'autor' => 'Brenda',
                'categoria_id' => $tecnologia->id
            ]);
        }
    }
}