<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XMLController;
use Inertia\Inertia;

class XMLAdminController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/XMLAdministration', [
            'xml_content' => XMLController::generateXML(),
            'xml_link' => route('xml'),
        ]);
    }
}
