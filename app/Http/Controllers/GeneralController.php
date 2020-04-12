<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        return response()->json([
            'name' => 'Scarlet API',
            'version' => $this->version
        ]);
    }
}
