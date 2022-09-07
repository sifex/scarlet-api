<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use GameQ\GameQ;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Shetabit\TokenBuilder\Facade\TokenBuilder;

class AppController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('Home', [
            'scarlet_download' => Inertia::lazy(
                fn () =>
                Auth::check() ? self::getLatestScarletDownloadLink() : ''
            )
        ]);
    }

    public function electron_intro_screen(): Response|\Illuminate\Http\RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('electron');
        }

        return Inertia::render('ElectronIntroScreen');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function browser_electron_steam_verify_page(Request $request): Response
    {
        if (Auth::check()) {
            $date = Carbon::now()->addMinutes(5);
            $token = Auth::user()
                ->temporaryTokenBuilder()
                ->setUsageLimit(1)
                ->setExpireDate($date)
                ->build();
        }

        return Inertia::render('BrowserElectronVerify', [
            'user' => Auth::user(),
            'token' => $token->token ?? ''
        ]);
    }

    public function electron_call_home(Request $request)
    {
        $token = TokenBuilder::setUniqueId($request->get('token'))->findValidToken();

        if (!$token) {
            return redirect()->route('electron.intro');
        }

        Auth::login($token->tokenable);

        return redirect()->route('electron');
    }

    /**
     * @throws \Throwable
     */
    private static function getLatestScarletDownloadLink(): string
    {
        if (env('APP_ENV') === 'testing' || env('APP_ENV') === 'local') {
            return 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
        } else {
            $github_release_information = GitHub::connection('main')->api('repo')->releases()->latest('sifex', 'scarlet');
            $assets = collect($github_release_information)->get('assets');
            throw_if(sizeof($assets) === 0, \Exception::class, 'No current available Scarlet download link');
            $download_asset = collect($assets)->filter(function ($asset) {
                return str_ends_with($asset['name'], '.exe');
            })->first();
            return collect($download_asset)->get('browser_download_url');
        }
    }

    /**
     * @throws \Exception
     */
    public static function queryArmaServer()
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
