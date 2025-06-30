<?php

namespace App\Notifications;

use App\Models\ServiceBooking;
use App\Services\WhatsappService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class TechnicianNewBooking extends Notification implements ShouldQueue
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
        $vehicle = $this->booking->vehicle;
        $plate   = $vehicle?->license_plate;
        $model   = $vehicle?->model;
        $customer = $this->booking->customer?->user?->name;
        $bookingCode = $this->booking->booking_code;
        $bookingDate = $this->booking->booking_date?->format('d M Y');

        $message = "Halo, Anda mendapat booking baru (#{$bookingCode}) dari {$customer} untuk kendaraan {$model} ({$plate}) pada {$bookingDate}. Silakan periksa aplikasi untuk detailnya.";

        WhatsappService::send($notifiable->phone, $message);
    }
}
