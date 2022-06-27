<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
//use GitHub;
use Carbon\Carbon;
use GameQ\GameQ;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Shetabit\TokenBuilder\Facade\TokenBuilder;

class AppController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('Home', [
            'current_user' => Auth::user(),
            'scarlet_download' => Inertia::lazy(
                fn () =>
                Auth::check() ? $this->getLatestScarletDownloadLink() : ''
            )
        ]);
    }

    public function electron(): Response
    {
        return Inertia::render('ElectronDownloader', [
            'current_user' => Auth::user(),
            'arma_server' => Inertia::lazy(fn () => $this->queryArmaServer())
        ]);
    }

    public function electron_intro_screen(): Response|\Illuminate\Http\RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('electron');
        }

        return Inertia::render('ElectronIntroScreen');
    }

    public function admin()
    {
        return redirect()->route('admin.usermanagement');
    }

    public function admin_user_management(): Response
    {
        return Inertia::render('Admin/UserManagement', [
            'current_user' => Auth::user(),
            'all_users' => User::all()
        ]);
    }

    public function manage_user(User $user): Response
    {
        return Inertia::render('Admin/ManageUser', [
            'current_user' => Auth::user(),
            'user' => $user
        ]);
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
            'current_user' => Auth::user(), # Used only for the "Welcome Username Banner"
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
    private function getLatestScarletDownloadLink(): string
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
