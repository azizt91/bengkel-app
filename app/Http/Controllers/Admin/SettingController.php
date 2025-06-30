<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $token = Setting::get('fonnte_token', env('FONNTE_TOKEN'));
        $url   = Setting::get('fonnte_url', env('FONNTE_URL'));

        return view('admin.settings.index', compact('token', 'url'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'url'   => 'required|url',
        ]);

        Setting::set('fonnte_token', $request->token);
        Setting::set('fonnte_url', $request->url);

        return back()->with('success', 'Settings updated');
    }
}
