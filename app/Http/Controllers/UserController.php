<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Get all users for Scarlet
     * Used for the administration of Scarlet
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        return response()->json(User::all()->toArray());
    }

    /**
     * Gets a specific user by key / username / id
     * @param User $user
     * @return JsonResponse
     */
    public function get(User $user): JsonResponse
    {
        return response()->json($user);
    }

    /**
     * @param User $user
     * @return array
     */
    private function rules(User $user): array
    {
        return [
            'username' => [
                'required',
                'string',
                Rule::unique('users')->ignore($user->id),
            ],
            'clanID' => 'required|numeric',
            'type' => 'required|string'
        ];
    }

    /**
     * @return array
     */
    private function messages(): array
    {
        return [];
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function add(Request $request): JsonResponse
    {
        $this->validate($request, $this->rules(User::make()), $this->messages());

        $user = User::create([
            'username' => $request->get('username'),
            'installDir' => '',
            'clanID' => $request->get('clanID'),
            'type' => $request->get('type')
        ]);

        Log::info('Created User: ' . $user->username . ' (' . $user->key . ') - ' . $user->clanID);

        return response()->json($user);
    }

    /**
     * Delete a User
     * @param User $user
     * @return JsonResponse
     * @throws \Exception
     */
    public function remove(User $user): JsonResponse
    {
        try {
            $user->delete();
        } catch (\Exception $e) {
            // TODO
        }

        Log::info('Removed user ' . $user->username);
        return response()->json(['status' => 'deleted']);
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, $this->rules($user), $this->messages());

        Log::info('Updating User ' . $user->username);

        $user->fill(
            $request->only([
                'installDir',
                'remark',
                'steamID',
                'comment',
                'type'
            ])
        )->save();


        return response()->json($user->fresh());
    }
}
