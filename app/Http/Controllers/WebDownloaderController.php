<?php

namespace App\Http\Controllers;

use App\Settings;
use Inertia\Inertia;
use Inertia\Response;

class WebDownloaderController extends Controller
{
    public function __construct()
    {
        $settings = Settings::latest()->firstOrCreate([
            'launcher_image_url' => 'https://i.imgur.com/0cm9dip.png',
            'welcome_image_url' => 'https://i.imgur.com/YVMCtcN.png',
        ]);

        Inertia::share([
            'welcome_image_url' => $settings->welcome_image_url,
            'launcher_image_url' => $settings->launcher_image_url,
        ]);
    }

    public function electron(): Response
    {
        return Inertia::render('ElectronDownloader', [
            'arma_server' => Inertia::lazy(fn () => AppController::queryArmaServer()),
            'launcher_image_url' => Settings::latest()->first()->launcher_image_url
        ]);
    }
}
