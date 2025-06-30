<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\ServiceBooking;
use App\Models\ServiceProgress;
use App\Services\WhatsappService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgressController extends Controller
{
    public function store(Request $request, ServiceBooking $booking)
    {
        // authorize that technician owns this booking
        abort_unless($booking->technician_id === auth()->user()->technician->id, 403);

        $data = $request->validate([
            'description' => ['required', 'string', 'max:1000'],
            
        ]);

        $photoPath = null;

        $progress = ServiceProgress::create([
            'booking_id' => $booking->id,
            'technician_id' => auth()->user()->technician->id,
            'status' => $booking->status,
            'description' => $data['description'],
            'photo_path' => null,
        ]);

        // send whatsapp notification to customer
        if ($booking->customer->user->phone) {
            $msg = "Booking {$booking->booking_code} update: {$progress->description}";
            WhatsappService::send($booking->customer->user->phone, $msg);
        }

        return back()->with('success', 'Progress added');
    }
}
