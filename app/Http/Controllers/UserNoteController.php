<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserNoteRequest;
use App\Http\Requests\UpdateUserNoteRequest;
use App\User;
use App\UserNote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserNoteController extends Controller
{
    /**
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
}
