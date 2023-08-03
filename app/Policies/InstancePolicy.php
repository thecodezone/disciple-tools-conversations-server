<?php

namespace App\Policies;

use App\Models\Instance;
use App\Models\User;

class InstancePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-any Instance');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Instance $instance): bool
    {
        if (! $user->instances->contains($instance)) {
            return false;
        }
        return $user->can('view Instance');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create Instance');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Instance $instance): bool
    {
        if (! $user->instances->contains($instance)) {
            return false;
        }
        return $user->can('update Instance');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Instance $instance): bool
    {
        if (! $user->instances->contains($instance)) {
            return false;
        }
        return $user->can('delete Instance');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Instance $instance): bool
    {
        return $user->can('restore Instance');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Instance $instance): bool
    {
        if (! $user->instances->contains($instance)) {
            return false;
        }
        return $user->can('force-delete Instance');
    }
}
