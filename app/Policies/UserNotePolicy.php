<?php

namespace App\Policies;

use App\User;
use App\UserNote;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserNotePolicy
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
}
