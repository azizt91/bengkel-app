<?php

namespace App\Notifications;

use App\Models\ServiceBooking;
use App\Services\WhatsappService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ServiceCompletedPaymentDue extends Notification implements ShouldQueue
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
        $customerName = $notifiable->name;
        $vehicle = $this->booking->vehicle;
        $model = $vehicle?->model;
        $plate = $vehicle?->license_plate;
        $amount = number_format($this->booking->estimated_cost,0,',','.');
        $appName = env('APP_NAME', 'Bengkel');

        $message = "Halo Bapak/Ibu *{$customerName}*,\n\n".
                   "Kami informasikan bahwa servis untuk mobil *{$model}* dengan plat nomor *{$plate}* telah selesai dan siap untuk diambil.\n\n".
                   "Total biaya servis adalah: *Rp {$amount}*\n\n".
                   "Pembayaran dapat dilakukan melalui transfer atau langsung di kasir kami. Terima kasih telah mempercayakan servis mobil Anda kepada kami.\n\n".
                   "Salam,\n*{$appName}*";

        WhatsappService::send($notifiable->phone, $message);
    }
}
