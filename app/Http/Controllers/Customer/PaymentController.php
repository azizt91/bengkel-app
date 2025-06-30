<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create(ServiceBooking $booking)
    {
        $this->authorizeBooking($booking);
        // If already paid, redirect
        if ($booking->payments()->exists()) {
            return redirect()->route('customer.bookings.show', $booking)->with('info', 'Payment already submitted');
        }
        return view('customer.payments.create', compact('booking'));
    }

    public function store(Request $request, ServiceBooking $booking)
    {
        $this->authorizeBooking($booking);
        $validated = $request->validate([
            'payment_method' => 'required|string|in:transfer,cash,credit_card,ewallet',
            'amount' => 'required|numeric|min:0',
            'transfer_proof' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'notes' => 'nullable|string|max:255',
        ]);

        if($request->hasFile('transfer_proof')){
            $path = $request->file('transfer_proof')->store('payments','public');
            $validated['proof_path'] = $path;
        }

        $validated['booking_id'] = $booking->id;
        $validated['payment_date'] = now();
        $validated['status'] = 'pending';

        Payment::create($validated);

        return redirect()->route('customer.bookings.show', $booking)->with('success', 'Payment submitted');
    }

    private function authorizeBooking(ServiceBooking $booking): void
    {
        abort_unless($booking->customer_id === auth()->user()->customer->id, 403);
    }
}
