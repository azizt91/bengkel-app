<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class DashboardRedirectController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect()->intended('/admin/dashboard');
        }

        if ($user->hasRole('teknisi')) {
            return redirect()->intended('/technician/dashboard');
        }

        // default pelanggan
        return redirect()->intended('/customer/dashboard');
    }
}
