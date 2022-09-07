<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class APIController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function update_user(Request $request, User $user): JsonResponse
    {
        $this->authorize('update', $user);

        $user->update(
            $request->validate([
                'username' => ['sometimes', 'required', 'string'],
                'remark' => ['sometimes', 'required', 'string'],
                'installDir' => ['sometimes', 'required', 'string']
            ])
        );

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }
}
