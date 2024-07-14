<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Settings;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingsAdminController extends Controller
{
    public function index(Request $request)
    {
        $settings = Settings::latest()->first();

        if ($settings === null) {
            $settings = Settings::create([
                'launcher_image_url' => 'https://i.imgur.com/0cm9dip.png',
                'welcome_image_url' => 'https://i.imgur.com/YVMCtcN.png',
            ]);
        }

        return Inertia::render('Admin/Settings', [
            ...$settings->only([
                'launcher_image_url',
                'welcome_image_url'
            ])
        ]);
    }
    public function update(Request $request, Auth $auth)
    {
        $request->validate([
            'launcher_image_url' => 'required|url',
            'welcome_image_url' => 'required|url',
        ]);

        $settings = Settings::create([
            'launcher_image_url' => $request->get('launcher_image_url'),
            'welcome_image_url' => $request->get('welcome_image_url'),
            'changed_by' => auth()->user()->id
        ]);

        return back()->with('success', 'Image uploaded Successfully!')
            ->with('settings', $settings);
    }
}
