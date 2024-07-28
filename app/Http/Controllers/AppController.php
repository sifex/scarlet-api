<?php

namespace App\Http\Controllers;

use App\Settings;
use Auth;
use Cache;
use Carbon\Carbon;
use GameQ\GameQ;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\ViewErrorBag;
use Inertia\Inertia;
use Inertia\Response;
use Shetabit\TokenBuilder\Facade\TokenBuilder;

class AppController extends Controller
{
    public function __construct()
    {
        $settings = Settings::latest('created_at')->firstOrCreate([], [
            'launcher_image_url' => 'https://i.imgur.com/0cm9dip.png',
            'welcome_image_url' => 'https://i.imgur.com/YVMCtcN.png',
        ]);

        Inertia::share([
            'welcome_image_url' => $settings->welcome_image_url,
            'launcher_image_url' => $settings->launcher_image_url,
        ]);
    }

    public function home(): Response
    {
        if (Auth::check()) {
            $token = $this->getNewToken();
        }

        return Inertia::render('Home', [
            'protocol' => 'scarlet',
            'token' => $token->token ?? '',
            'scarlet_download' => Inertia::lazy(
                fn () => Auth::check() ? self::getLatestScarletDownloadLink() : ''
            )
        ]);
    }

    public function error(): Response|RedirectResponse
    {
        if (sizeof(session()->get('errors', app(ViewErrorBag::class))) === 0) {
            return redirect()->route('home');
        }

        return Inertia::render('ErrorLogin');
    }

    public function electron_intro_screen(): Response|RedirectResponse
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
            $token = $this->getNewToken();
        }

        return Inertia::render('BrowserElectronVerify', [
            'token' => $token->token ?? '',
            'protocol' => 'scarlet'
        ]);
    }

    public function electron_call_home(Request $request): RedirectResponse
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
        if (Cache::has('scarlet_download_link')) {
            return Cache::get('scarlet_download_link');
        }

        $link = self::generateGithubDownloadLink();
        Cache::put('scarlet_download_link', $link, now()->addDays(5));
        return $link;
    }

    /**
     * @throws \Throwable
     */
    private static function generateGithubDownloadLink(): string
    {
        $github_release_information = GitHub::connection('main')->api('repo')->releases()->latest('sifex', 'scarlet');
        $assets = collect($github_release_information)->get('assets');
        throw_if(sizeof($assets) === 0, \Exception::class, 'No current available Scarlet download link');
        $download_asset = collect($assets)->filter(function ($asset) {
            return str_ends_with($asset['name'], '.exe');
        })->first();
        return collect($download_asset)->get('browser_download_url');
    }


    /**
     * @throws \Exception
     */
    public static function queryArmaServer()
    {
        $servers = [
            [
                'type' => 'armedassault3',
                'host' => '58.162.184.102:2302',
            ]
        ];

        $GameQ = new GameQ();
        $GameQ->addServers($servers);
        $GameQ->setOption('timeout', 5); // seconds

        return collect($GameQ->process())->first();
    }

    /**
     * @return \Shetabit\TokenBuilder\Models\Token
     */
    private function getNewToken(): \Shetabit\TokenBuilder\Models\Token
    {
        $date = Carbon::now()->addMinutes(5);
        $token = Auth::user()
            ->temporaryTokenBuilder()
            ->setUsageLimit(1)
            ->setExpireDate($date)
            ->build();

        return $token;
    }

    public function electron(): Response
    {
        return Inertia::render('ElectronDownloader', [
            'arma_server' => Inertia::lazy(fn () => AppController::queryArmaServer()),
            'launcher_image_url' => Settings::latest()->first()->launcher_image_url
        ]);
    }
}
