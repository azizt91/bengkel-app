<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\ServiceBooking;
use App\Models\SparePart;
use App\Models\ServiceDetail;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $tech = auth()->user()->technician;
        $status = $request->query('status');

        if($status === 'available'){
            $query = ServiceBooking::whereNull('technician_id');
        } else {
            $query = ServiceBooking::where('technician_id', $tech->id);
            if($status){
                $query->where('status', $status);
            }
        }
        $bookings = $query->with(['vehicle','customer'])->latest()->paginate(15);
        return view('technician.bookings.index', compact('bookings','status'));
    }

    public function show(ServiceBooking $booking)
    {
        $this->authorizeBooking($booking);
        $booking->load(['vehicle','customer','serviceCategory','serviceDetails.sparePart']);
        $spareParts = SparePart::where('is_active', true)->orderBy('name')->get();

        // Prepare JS-friendly data
        $serviceDetailsForJs = $booking->serviceDetails->map(function($d){
            return [
                'type' => $d->type === 'part' ? 'part' : 'service',
                'description' => $d->description,
                'spare_part_id' => $d->spare_part_id,
                'quantity' => $d->quantity,
                'unit_price' => (float) $d->unit_price,
            ];
        })->values();
        $sparePartsMap = $spareParts->pluck('price','id');

        return view('technician.bookings.show', compact('booking','spareParts','serviceDetailsForJs','sparePartsMap'));
    }

    public function update(Request $request, ServiceBooking $booking)
    {
        $this->authorizeBooking($booking);
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
            'estimated_duration' => ['nullable','integer','min:1'],
            'notes' => ['nullable','string','max:500'],
        ]);
        $updateData = ['status' => $validated['status']];
        if(isset($validated['estimated_duration'])){
            $updateData['estimated_duration'] = $validated['estimated_duration'];
        }

        if(isset($validated['notes'])){
            $updateData['notes'] = $validated['notes'];
        }
        $booking->update($updateData);

        // notify customer via whatsapp kecuali jika status completed
        if($booking->customer && $booking->customer->user && $booking->customer->user->phone){
            if($validated['status']==='in_progress'){
                $booking->customer->user->notify(new \App\Notifications\BookingInProgress($booking));
            } elseif($validated['status']!=='completed'){
                $booking->customer->user->notify(new \App\Notifications\BookingStatusUpdated($booking));
            }
        }

        return back()->with('success','Status updated');
    }

    public function claim(ServiceBooking $booking)
    {
        abort_if($booking->technician_id, 400, 'Already assigned');
        $booking->update(['technician_id' => auth()->user()->technician->id]);
        // Notify customer
        if($booking->customer && $booking->customer->user && $booking->customer->user->phone){
            $booking->customer->user->notify(new \App\Notifications\BookingClaimed($booking));
        }
        return back()->with('success', 'Booking claimed & customer notified');
    }

    private function authorizeBooking(ServiceBooking $booking): void
    {
        abort_unless($booking->technician_id === auth()->user()->technician->id, 403);
    }
}
