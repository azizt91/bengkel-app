<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(ServiceBooking $booking)
    {
        $this->authorizeBooking($booking);
        // only allow if not yet reviewed
        if ($booking->reviews()->where('customer_id', auth()->user()->customer->id)->exists()) {
            return redirect()->route('customer.bookings.show', $booking)->with('info', 'You already reviewed this service');
        }
        return view('customer.reviews.create', compact('booking'));
    }

    public function store(Request $request, ServiceBooking $booking)
    {
        $this->authorizeBooking($booking);
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $validated['booking_id'] = $booking->id;
        $validated['customer_id'] = auth()->user()->customer->id;
        $validated['technician_id'] = $booking->technician_id;

        Review::create($validated);

        return redirect()->route('customer.bookings.show', $booking)->with('success', 'Thank you for your feedback!');
    }

    private function authorizeBooking(ServiceBooking $booking): void
    {
        abort_unless($booking->customer_id === auth()->user()->customer->id, 403);
    }
}
