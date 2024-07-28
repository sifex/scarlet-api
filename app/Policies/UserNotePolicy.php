<?php

namespace App\Policies;

use App\User;
use App\UserNote;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserNotePolicy
{
    use HandlesAuthorization;

    public function create(): bool
    {
        return auth()->user()->isAdministrator();
    }

    public function destroy(User $user, UserNote $note): bool
    {
        return auth()->user()->isAdministrator();
    }
}
