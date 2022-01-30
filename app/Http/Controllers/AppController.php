<?php

namespace App\Http\Controllers;

use Auth;
//use GitHub;
use GameQ\GameQ;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AppController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('Home', [
            'user' => Auth::user(),
            'scarlet_download' => Inertia::lazy(fn () =>
                Auth::check() ? $this->getLatestScarletDownloadLink() : ''
            )
        ]);
    }

    public function about(): Response
    {
        return Inertia::render('About', [
            'user' => Auth::user()
        ]);
    }

    public function electron(): Response
    {
        return Inertia::render('Electron', [
            'user' => Auth::user(),
            'arma_server' => Inertia::lazy(fn () => $this->queryArmaServer())
        ]);
    }

    public function electron_steam_login()
    {
        if(Auth::check()) { return redirect()->route('electron'); }

        return Inertia::render('ElectronSteamLogin');
    }


    public function electron_steam_login_verify()
    {
        return Inertia::render('ElectronSteamLoginVerify');
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

    /**
     * @throws \Exception
     */
    private function queryArmaServer()
    {
        $servers = [
            [
                'type'    => 'armedassault3',
                'host'    => '58.162.184.102:2302',
            ]
        ];

        $GameQ = new GameQ();
        $GameQ->addServers($servers);
        $GameQ->setOption('timeout', 5); // seconds

        return collect($GameQ->process())->first();
    }
}
