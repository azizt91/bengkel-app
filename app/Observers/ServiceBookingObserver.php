<?php

namespace App\Observers;

use App\Models\ServiceBooking;
use App\Notifications\TechnicianNewBooking;

class ServiceBookingObserver
{
    public function created(ServiceBooking $booking): void
    {
        if ($booking->technician_id && $booking->technician?->user) {
            $booking->technician->user->notify(new TechnicianNewBooking($booking));
        }
    }

    public function updated(ServiceBooking $booking): void
    {
        if ($booking->isDirty('technician_id') && $booking->technician_id && $booking->technician?->user) {
            $booking->technician->user->notify(new TechnicianNewBooking($booking));
        }
    }
}
