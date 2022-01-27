<?php

namespace App\Http\Controllers;

use Auth;
//use GitHub;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('Home', [
            'user' => Auth::user(),
            'scarlet_download' =>  Auth::check() ? $this->getLatestScarletDownloadLink() : ''
        ]);
    }

    public function about(): Response
    {
        return Inertia::render('About', [
            'user' => Auth::user()
        ]);
    }

    /**
     * @throws \Throwable
     */
    private function getLatestScarletDownloadLink(): string
    {
        $github_release_information = GitHub::api('repo')->releases()->latest('sifex', 'scarlet');
        $assets = collect($github_release_information)->get('assets');
        throw_if(sizeof($assets) === 0, \Exception::class, 'No current available Scarlet download link');
        $download_asset = collect($assets)->filter(function($asset) { return str_ends_with($asset['name'], '.exe'); })->first();
        return collect($download_asset)->get('browser_download_url');
    }
}
