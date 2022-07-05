<?php

namespace App\Http\Controllers;

use App\Enum\UserRole;
use App\User;
use Auth;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class UserController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->authorizeResource(User::class, 'model');
//        User::addGlobalScope('with_notes', fn(Builder $builder) => $builder->with('notes'));
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
            'current_user' => Auth::user(),
            'all_users' => Inertia::lazy(fn () => User::with('notes')->get())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function create(): Response
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
                'type' => [new Enum(UserRole::class)],
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
            'current_user' => Auth::user()->load('notes'),
            'user' => $user->loadMissing('notes')
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
                'username' => ['max:50'],
                'type' => [new Enum(UserRole::class)],
                'remark' => ['string', 'max:150'],
                'comment' => ['string'],
            ])
        );

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     * @throws Throwable
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        throw_unless(
            $user->delete(),
            Exception::class,
            "Couldn't delete user"
        );

        return redirect()->route('user.index');
    }
}
