<?php

namespace App\Policies;

use App\Enum\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(Permission::VIEW_USERS);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->can(Permission::VIEW_USERS);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(Permission::CREATE_USER);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->can(Permission::EDIT_USER) and !$model->isSuperAdmin();
    }

    public function impersonate(User $user, ?User $impersonated = null): bool
    {
        if (is_impersonating()) {
            return false;
        }

        if ($impersonated and !$impersonated->canBeImpersonated()) {
            return false;
        }

        return $user->isSuperAdmin() or $user->hasPermissionTo(Permission::IMPERSONATE);
    }

    public function beImpersonated(User $user, User $impersonated): bool
    {
        if ($impersonated->isSuperAdmin()) {
            return false;
        }

        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->hasPermissionTo(Permission::IMPERSONATE)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->can(Permission::DELETE_USER) and !$model->isSuperAdmin();
    }
}
