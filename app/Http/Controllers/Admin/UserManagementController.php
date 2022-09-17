<?php

namespace App\Http\Controllers\Admin;

use App\Enum\UserRole;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Log;
use Throwable;

class UserManagementController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->authorizeResource(User::class, 'model');
//        User::addGlobalScope('with_notes', fn(Builder $builder) => $builder->);
    }

    public function redirect_to_user_management(): RedirectResponse
    {
        return redirect()->route('admin.user.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function index(): Response
    {
        $this->authorize('viewAny', User::class);

        return Inertia::render('Admin/UserManagement', [
            'all_users' => Inertia::lazy(fn () => User::withTrashed()->get())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function create(): RedirectResponse
    {
        $this->authorize('create', User::class);

        return redirect()->route('admin.user.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        User::create(
            $request->validate([
                'username' => ['required', 'max:50'],
                'type' => [
                    'required',
                    new Enum(UserRole::class)
                ],
            ])
        );

        return redirect()->route('electron');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     * @throws AuthorizationException
     */
    public function show(User $user): Response
    {
        $this->authorize('view', $user);

        return Inertia::render('Admin/ViewUser', [
            'user' => $user->load('notes')->makeVisible(['notes'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user): Response
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $user->update(
            $request->validate([
                'username' => ['sometimes', 'required', 'string', 'max:50'],
                'type' => [
                    'sometimes',
                    'required',
                    new Enum(UserRole::class),
                    function ($attribute, $value, $fail) use ($user) {
                        if (
                            $user->uuid === auth()->user()->uuid
                            &&
                            $value !== $user->type->value
                        ) {
                            $fail('You cannot change your own role');
                        }
                    }
                ],
                'remark' => ['string', 'max:150', 'nullable'],
                'comment' => ['string', 'nullable'],

            ])
        );

        Log::info(auth()->user()->username . ' just modified user ' . $user->username . ' with the following: (' . json_encode($request->toArray()) . ')');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @param Request $request
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function destroy(User $user, Request $request): RedirectResponse
    {
        $this->authorize('delete', $user);

        if($user->uuid === auth()->user()->uuid) {
            return redirect()->back()->withErrors([
                'You can\'t delete yourself'
            ]);
        }

        throw_unless(
            $request->get('restore')
                ? $user->restore()
                : $user->delete(),
            Exception::class,
            "Couldn't delete user"
        );

        Log::info(auth()->user()->username . ' just deleted user ' . $user->username  . '.');

        return redirect()->back();
    }
}
