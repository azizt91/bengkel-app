<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ServiceBooking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function download(ServiceBooking $booking)
    {
        // authorize customer owns booking
        abort_unless($booking->customer && $booking->customer->user_id === auth()->id(), 403);

        $booking->load(['vehicle','serviceCategory','payments']);

        $pdf = Pdf::loadView('invoices.booking', [
            'booking' => $booking,
        ]);

        return $pdf->download("invoice_{$booking->booking_code}.pdf");
    }
}
