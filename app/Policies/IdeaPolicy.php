<?php

namespace App\Policies;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class IdeatPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user-›rol, ['admin', 'coordinador', 'asistente']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Idea $idea): bool
    {
        return in_array($user-›rol, ['admin', 'coordinador', 'asistente']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->rol === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Idea $idea): bool
    {
        return in_array($user-›rol, ['admin', 'asistente']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Idea $idea): bool
    {
        return in_array($user-›rol, ['admin', 'asistente']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Idea $idea): bool
    {
        return in_array($user-›rol, ['admin', 'asistente']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Idea $idea): bool
    {
        return in_array($user-›rol, ['admin', 'asistente']);
    }

    public function cambiarEstado(User $user, Idea $idea): bool
    {
        return in_array($user-›rol, ['admin', 'coordinador']);
    }
}
