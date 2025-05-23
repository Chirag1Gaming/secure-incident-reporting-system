<?php

namespace App\Policies;

use App\Models\Incident;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IncidentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        // Admins and Super Admin can view all, users can only view their own
        return $user->hasAnyRole(['User', 'Admin', 'Super Admin']);
    }

    public function view(User $user, Incident $incident)
    {
        return $user->hasRole('Super Admin')
            || $user->hasRole('Admin')
            || ($user->hasRole('User') && $incident->user_id === $user->id);
    }

    public function create(User $user)
    {
        return $user->hasRole('User');
    }

    public function update(User $user, Incident $incident)
    {
        // Admins and Super Admin can update incidents
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }

    public function delete(User $user, Incident $incident)
    {
        // Only Super Admin can delete permanently
        return $user->hasRole('Super Admin');
    }
}
