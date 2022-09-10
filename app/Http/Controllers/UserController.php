<?php

namespace App\Http\Controllers;

use App\Enum\UserRole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $this->authorize('update', $request->user());

        $request->user()->update(
            $request->validate([
                'username' => ['sometimes', 'required', 'string', 'max:50'],
                'remark' => ['sometimes', 'string', 'max:150', 'nullable'],
                'installDir' => ['sometimes', 'required', 'string', 'max:350']
            ])
        );

        return redirect()->back();
    }
}
