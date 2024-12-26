<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $current_user): Response|bool
    {
        return auth()->user()->isAdministrator();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $current_user, User $model): Response|bool
    {
        return auth()->user()->isAdministrator();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $current_user): Response|bool
    {
        return auth()->user()->isAdministrator();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function edit(User $current_user, User $model): Response|bool
    {
        return auth()->user()->isAdministrator();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $current_user, User $model): Response|bool
    {
        return auth()->user()->isAdministrator() || $current_user->uuid === $model->uuid;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $current_user, User $model): Response|bool
    {
        return auth()->user()->isAdministrator();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $current_user, User $model): Response|bool
    {
        return auth()->user()->isAdministrator();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $current_user, User $model): Response|bool
    {
        return auth()->user()->isAdministrator();
    }
}
