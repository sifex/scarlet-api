<?php

namespace App\Http\Controllers\V2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\InviteCode;

class InviteController extends Controller
{
    public function index(Request $request) {
        $inviteCode = new InviteCode();

        return view('V2/index', [$request, $inviteCode]);
    }
}
