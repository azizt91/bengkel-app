<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ServiceBooking;
use App\Observers\ServiceBookingObserver;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use App\Services\WhatsappService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ServiceBooking::observe(ServiceBookingObserver::class);

        // Register custom whatsapp channel
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('whatsapp', function ($app) {
                return new class {
                    public function send($notifiable, $notification)
                    {
                        if (!method_exists($notification, 'toWhatsapp')) {
                            return;
                        }
                        return $notification->toWhatsapp($notifiable);
                    }
                };
            });
        });
    }
}
