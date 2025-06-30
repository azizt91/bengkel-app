<?php

namespace App\Notifications;

use App\Models\ServiceBooking;
use App\Services\WhatsappService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class BookingClaimed extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private ServiceBooking $booking){}

    public function via($notifiable): array
    {
        return ['whatsapp'];
    }

    public function toWhatsapp($notifiable): void
    {
        $customerName = $notifiable->name;
        $vehicle      = $this->booking->vehicle;
        $vehicleText  = $vehicle?->model ?? $vehicle?->license_plate;
        $tech         = $this->booking->technician?->user;
        if(!$tech){
            return; // technician missing
        }
        $techName  = $tech->name;
        $techPhone = $tech->phone;
        $appName   = env('APP_NAME', 'Bengkel');

        $message = "Halo *{$customerName}*,\n\n".
                   "Booking Anda untuk mobil *{$vehicleText}* telah di-claim oleh teknisi kami:\n\n".
                   "• *Teknisi :* *{$techName}\n".
                   "• *Kontak:* {$techPhone}n\n".              
                   "Kami akan segera memulai proses pengerjaan. Anda akan mendapatkan update selanjutnya saat status berubah.\n\n".
                   "Salam,\n*{$appName}*";

        WhatsappService::send($notifiable->phone, $message);
    }
}
