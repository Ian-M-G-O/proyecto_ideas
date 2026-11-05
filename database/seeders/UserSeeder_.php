<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = [
            [
                'name' => 'Coordinador',
                'email' => 'coordinador@ideas.com',
                'rol' => 'coordinador',
            ],
            [
                'name' => 'Asistente',
                'email' => 'asistente@ideas.com',
                'rol' => 'asistente',
            ],
        ];

        foreach ($usuarios as $usuario) {
            User::updateOrCreate(
                ['email' => $usuario['email']],
                [
                    'name' => $usuario['name'],
                    'password' => bcrypt('12345'),
                    'rol' => $usuario['rol'],
                ]
            );
        }
    }
}
