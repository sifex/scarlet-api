<?php

namespace App\Http\Controllers;

use App\Settings;
use Inertia\Inertia;
use Inertia\Response;

class WebDownloaderController extends Controller
{
    public function electron(): Response
    {
        return Inertia::render('ElectronDownloader', [
            'arma_server' => Inertia::lazy(fn () => AppController::queryArmaServer()),
            'launcher_image_url' => Settings::latest()->first()->launcher_image_url
        ]);
    }
}
