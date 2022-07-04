<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param User $current_user
     * @return void|bool
     */
    public function before(User $current_user)
    {
        if (auth()->user()->isAdministrator()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param User $current_user
     * @return Response|bool
     */
    public function viewAny(User $current_user): Response|bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $current_user
     * @param User $model
     * @return Response|bool
     */
    public function view(User $current_user, User $model): Response|bool
    {
        return $current_user->uuid === $model->uuid;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $current_user
     * @return Response|bool
     */
    public function create(User $current_user): Response|bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $current_user
     * @param User $model
     * @return Response|bool
     */
    public function edit(User $current_user, User $model): Response|bool
    {
        return $current_user->uuid === $model->uuid;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $current_user
     * @param User $model
     * @return Response|bool
     */
    public function update(User $current_user, User $model): Response|bool
    {
        return $current_user->uuid === $model->uuid;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $current_user
     * @param User $model
     * @return Response|bool
     */
    public function delete(User $current_user, User $model): Response|bool
    {
        return $current_user->uuid === $model->uuid;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $current_user
     * @param User $model
     * @return Response|bool
     */
    public function restore(User $current_user, User $model): Response|bool
    {
        return $current_user->uuid === $model->uuid;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $current_user
     * @param User $model
     * @return Response|bool
     */
    public function forceDelete(User $current_user, User $model): Response|bool
    {
        return $current_user->uuid === $model->uuid;
    }
}
