<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Get all users for Scarlet
     * Used for the administration of Scarlet
     * @return JsonResponse
     */
    public function getAll()
    {
        return response()->json(User::all()->toArray());
    }

    /**
     * Gets a specific user by key / username / id
     * @param User $user
     * @return JsonResponse
     */
    public function get(User $user)
    {
        return response()->json($user);
    }

    /**
     * @return array
     */
    private function rules()
    {
        return [
            'username' => 'string',
            'clanID' => 'number',
            'type' => 'string'
        ];
    }

    /**
     * @return array
     */
    private function messages()
    {
        return [];
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function addUser(Request $request): JsonResponse
    {
        $this->validate($request, $this->rules(), $this->messages());

        $user = User::create([
            'username' => $request->get('username'),
            'installDir' => '',
            'key' => md5(strtolower($request->get('username')) . 'E6hJ9X2AptWH6bqU32'),
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

    /**
     * @param Request $request
     * @param $key
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // Log
        Log::info('Installing Directory for ' . $key . ': ' . $request->installDir);

        $user = User::where('key', $key)->first();

        if($user)
        {
            $user->installDir = $request->installDir;

            try {
                $user->save();
            } catch(Exception $exception) {
                /**
                 * This should return a json value, but this means pushing another scarlet updater update. TODO
                 * @return {[type] [description]
                 */
                return response('');
            }
        }
    }
}
