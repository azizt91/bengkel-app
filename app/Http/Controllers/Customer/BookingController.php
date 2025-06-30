<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ServiceBooking;
use App\Models\ServiceCategory;
use App\Models\Vehicle;
use App\Models\ServiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        $customer = auth()->user()->customer;
        $bookings = $customer->serviceBookings()->with(['vehicle','serviceCategory'])->latest()->paginate(10);
        return view('customer.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $customer = auth()->user()->customer;
        $vehicles = $customer->vehicles()->pluck('license_plate', 'id');
        $categories = ServiceCategory::where('is_active', true)->pluck('name', 'id');
        return view('customer.bookings.create', compact('vehicles', 'categories'));
    }

    public function store(Request $request)
    {
        $customer = auth()->user()->customer;
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'service_category_id' => 'required|exists:service_categories,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'custom_request' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
        ]);

        $validated['customer_id'] = $customer->id;
        $validated['booking_code'] = strtoupper(Str::random(8));
        $validated['status'] = 'pending';

        // copy default duration
        $validated['estimated_duration'] = ServiceCategory::find($validated['service_category_id'])->estimated_duration ?? null;

        // ensure custom_request only set if category is custom
        $customCategoryId = ServiceCategory::where('name', 'Lain-lain (Custom)')->value('id');
        if ($validated['service_category_id'] != $customCategoryId) {
            $validated['custom_request'] = null;
        }

        $booking = ServiceBooking::create($validated);

        // Automatically create initial service detail based on chosen category
        $category = ServiceCategory::find($validated['service_category_id']);
        if ($category) {
            ServiceDetail::create([
                'booking_id' => $booking->id,
                'spare_part_id' => null,
                'description' => $category->name === 'Lain-lain (Custom)' ? ($validated['custom_request'] ?? 'Custom Service') : $category->name,
                'quantity' => 1,
                'unit_price' => $category->name === 'Lain-lain (Custom)' ? 0 : $category->base_price,
                'total_price' => $category->name === 'Lain-lain (Custom)' ? 0 : $category->base_price,
                'type' => 'labor',
            ]);
        }

        return redirect()->route('customer.bookings.show', $booking)->with('success','Booking created');
    }

    public function show(ServiceBooking $booking)
    {
        $this->authorizeBooking($booking);
        $booking->load(['vehicle','serviceCategory','payments','serviceProgress']);
        return view('customer.bookings.show', compact('booking'));
    }

    private function authorizeBooking(ServiceBooking $booking): void
    {
        abort_unless($booking->customer_id === auth()->user()->customer->id, 403);
    }
}
