<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserNoteRequest;
use App\Http\Requests\UpdateUserNoteRequest;
use App\User;
use App\UserNote;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

class UserNoteController extends Controller
{
    /**
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function create(Request $request, User $user): RedirectResponse
    {
        $this->authorize('create', UserNote::class);

        $user->notes()->create([
            ...$this->validate($request, [
                'contents' => ['required']
            ]),
            'author_id' => auth()->user()->id
        ]);

        return redirect()->route('admin.user.show', ['user' => $user]);
    }

    /**
     * @throws ValidationException
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function destroy(User $user, UserNote $note): RedirectResponse
    {
        $this->authorize('destroy', $note);

        throw_unless(
            $note->delete(),
            Exception::class,
            'Could not delete Note'
        );

        return redirect()->route('admin.user.show', ['user' => $user]);
    }
}
