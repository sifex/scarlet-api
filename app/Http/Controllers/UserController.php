<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $this->authorize('update', $request->user());

        // Transform installDir before validation
        $request->merge([
            'installDir' => UserController::transformInstallDir($request->input('installDir'))
        ]);

        $request->user()->update(
            $request->validate([
                'username' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('users')->ignore($request->user()->id)
                ],
                'remark' => [
                    'sometimes',
                    'string',
                    'max:150',
                    'nullable'
                ],
                'installDir' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:350'
                ]
            ])
        );

        return redirect()->back();
    }

    public static function transformInstallDir($installDir): ?string
    {
        if ($installDir === null) {
            return null;
        }

        // Remove "/Directory" or "/Directory/" suffix if it exists
        $installDir = preg_replace('~/' . ModsController::MODS_PREFIX . '/?$~', '', $installDir);
        $installDir = preg_replace("~\\\\" . ModsController::MODS_PREFIX . "\\\\?\$~", '', $installDir);

        // Remove trailing slash if it exists
        return rtrim($installDir, '\/');
    }
}
