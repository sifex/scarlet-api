<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $this->authorize('update', $request->user());

        $request->user()->update(
            $request->validate([
                'username' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:50'
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
}
