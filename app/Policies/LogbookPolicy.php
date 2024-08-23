<?php

namespace App\Policies;

use App\Models\Logbook;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LogbookPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Logbook $logbook): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Logbook $logbook): bool
    {
        // Example 2: Check if the user has a specific role
        if ($user->hasRole('superadmin')) {
            return true;
        }

        // Example 3: Check if the user is the owner of the logbook
        if ($user->intern->id === $logbook->intern_id) {
            return true;
        }

        return false; 
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Logbook $logbook): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Logbook $logbook): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Logbook $logbook): bool
    {
        //
    }
}
