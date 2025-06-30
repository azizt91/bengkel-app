<?php

namespace App\Notifications;

use App\Models\ServiceBooking;
use App\Services\WhatsappService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class BookingStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private ServiceBooking $booking)
    {
    }

    public function via($notifiable): array
    {
        return ['whatsapp'];
    }

    public function toWhatsapp($notifiable): void
    {
        $customer = $this->booking->customer?->user?->name;
        $vehicle = $this->booking->vehicle;
        $plate   = $vehicle?->license_plate;
        $model   = $vehicle?->model;
        $status  = $this->booking->status;

        $message = "Halo {$customer}, service dengan kode booking #{$this->booking->booking_code} untuk kendaraan {$model} ({$plate}) kini berstatus {$status}.";
        WhatsappService::send($notifiable->phone, $message);
    }
}
