<?php
 
namespace App\Policies;
 
use App\Models\Categoria;
use App\Models\Usuario;
 
class CategoriaPolicy
{
    public function viewAny(Usuario $usuario): bool
    {
        return in_array($usuario->rol, ['admin', 'coordinador', 'asistente']);
    }
 
    public function view(Usuario $usuario, Categoria $categoria): bool
    {
        return in_array($usuario->rol, ['admin', 'coordinador', 'asistente']);
    }
 
    public function create(Usuario $usuario): bool
    {
        return $usuario->rol === 'admin';
    }
 
    public function update(Usuario $usuario, Categoria $categoria): bool
    {
        return in_array($usuario->rol, ['admin', 'asistente']);
    }
 
    public function delete(Usuario $usuario, Categoria $categoria): bool
    {
        return $usuario->rol === 'admin';
    }
 
    public function restore(Usuario $usuario, Categoria $categoria): bool
    {
        return $usuario->rol === 'admin';
    }
 
    public function forceDelete(Usuario $usuario, Categoria $categoria): bool
    {
        return $usuario->rol === 'admin';
    }
}