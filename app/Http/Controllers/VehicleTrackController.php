<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleTrackController extends Controller
{
    /**
     * Display vehicle history by QR token (public endpoint).
     */
    public function __invoke(string $token)
    {
        $vehicle = Vehicle::where('qr_token', $token)
            ->with(['serviceBookings' => function ($q) {
                $q->latest()->with(['serviceProgress', 'payment']);
            }])
            ->firstOrFail();

        // Log scan
        \App\Models\QrScan::create([
            'vehicle_id' => $vehicle->id,
            'token' => $token,
            'ip_address' => request()->ip(),
            'user_agent' => substr(request()->userAgent(),0,512),
        ]);

        return view('vehicle.track', compact('vehicle'));
    }
}
