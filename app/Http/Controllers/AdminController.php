<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminController extends Controller
{
    //
    public static function admin()
    {
        return redirect()->route('admin.usermanagement');
    }

    public static function admin_user_management(): Response
    {
        return Inertia::render('Admin/UserManagement', [
            'current_user' => Auth::user(),
            'all_users' => Inertia::lazy(fn () => User::all())
        ]);
    }

    public function manage_user(User $user): Response
    {
        return Inertia::render('Admin/ManageUser', [
            'current_user' => Auth::user(),
            'user' => $user
        ]);
    }
}
