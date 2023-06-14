<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Service;
use App\Models\User;

class ServicePolicy
{
    private function ownedBy(User $user, Service $service) {
        $instance = $service->instance;
        if (!$user->instances->contains($instance)) {
            return false;
        }
        return true;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-any Service');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Service $service): bool
    {
        if (!$this->ownedBy($user, $service)) {
            return false;
        }
        return $user->can('view Service');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create Service');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Service $service): bool
    {
        if (!$this->ownedBy($user, $service)) {
            return false;
        }
        return $user->can('update Service');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Service $service): bool
    {
        if (!$this->ownedBy($user, $service)) {
            return false;
        }
        return $user->can('delete Service');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Service $service): bool
    {
        if (!$this->ownedBy($user, $service)) {
            return false;
        }
        return $user->can('restore Service');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Service $service): bool
    {
        if (!$this->ownedBy($user, $service)) {
            return false;
        }
        return $user->can('force-delete Service');
    }
}
