<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = auth()->user()->customer->vehicles()->latest()->paginate(10);
        return view('customer.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('customer.vehicles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'license_plate' => 'required|string|max:20|unique:vehicles,license_plate',
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'nullable|digits:4',
            'color' => 'nullable|string|max:30',
        ]);

        $validated['customer_id'] = auth()->user()->customer->id;
        $validated['qr_token'] = \Illuminate\Support\Str::uuid();

        /** @var \App\Models\Vehicle $vehicle */
        $vehicle = \App\Models\Vehicle::create($validated);

        // Generate QR Code PNG and store in storage/app/public/qrcodes/{id}.png
        $qr = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
            ->size(300)
            ->generate(route('vehicle.track', $vehicle->qr_token));
        \Illuminate\Support\Facades\Storage::disk('public')->put("qrcodes/{$vehicle->id}.svg", $qr);

        return redirect()->route('customer.vehicles.index')->with('success','Vehicle added & QR generated');
    }

    public function show(Vehicle $vehicle)
    {
        $this->authorizeVehicle($vehicle);
        return view('customer.vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $this->authorizeVehicle($vehicle);
        return view('customer.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $this->authorizeVehicle($vehicle);
        $validated = $request->validate([
            'license_plate' => 'required|string|max:20|unique:vehicles,license_plate,'.$vehicle->id,
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'nullable|digits:4',
            'color' => 'nullable|string|max:30',
        ]);

        $vehicle->update($validated);
        return redirect()->route('customer.vehicles.index')->with('success','Vehicle updated');
    }

    public function destroy(Vehicle $vehicle)
    {
        $this->authorizeVehicle($vehicle);
        $vehicle->delete();
        return redirect()->route('customer.vehicles.index')->with('success','Vehicle deleted');
    }

    public function regenerateQr(Vehicle $vehicle)
    {
        $this->authorizeVehicle($vehicle);
        // generate new token & qr
        $vehicle->qr_token = \Illuminate\Support\Str::uuid();
        $vehicle->save();

        $qr = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
            ->size(300)
            ->generate(route('vehicle.track', $vehicle->qr_token));
        \Illuminate\Support\Facades\Storage::disk('public')->put("qrcodes/{$vehicle->id}.svg", $qr);

        return back()->with('success','QR regenerated');
    }

    private function authorizeVehicle(Vehicle $vehicle): void
    {
        abort_unless($vehicle->customer_id === auth()->user()->customer->id, 403);
    }
}
