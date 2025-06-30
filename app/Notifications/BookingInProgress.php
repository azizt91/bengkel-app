<?php

namespace App\Notifications;

use App\Models\ServiceBooking;
use App\Services\WhatsappService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class BookingInProgress extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private ServiceBooking $booking){}

    public function via($notifiable): array
    {
        return ['whatsapp'];
    }

    public function toWhatsapp($notifiable): void
    {
        $code        = $this->booking->booking_code;
        $vehicle     = $this->booking->vehicle;
        $vehicleText = $vehicle?->model ?? $vehicle?->license_plate;
        $duration    = $this->booking->estimated_duration ?? '-';
        $techName    = $this->booking->technician?->user?->name ?? '-';
        $appName     = env('APP_NAME', 'Bengkel');

        $message = "Booking Update: *{$code}* - In Progress\n\n".
                   "Pengerjaan mobil *{$vehicleText}* Anda telah dimulai.\n\n".
                   "• Estimasi Selesai: *{$duration} menit*.\n".
                   "• Teknisi: *{$techName}*.\n\n".
                   "Notifikasi selanjutnya akan dikirim saat servis selesai.\n\n".
                   "{$appName}";

        WhatsappService::send($notifiable->phone, $message);
    }
}
