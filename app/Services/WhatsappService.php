<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    public static function send(string $phone, string $message): bool
    {
        $token = config('services.fonnte.token');
        $url = config('services.fonnte.url', 'https://api.fonnte.com/send');

        if (!$token) {
            Log::warning('Fonnte token not set');
            return false;
        }

        $response = Http::withHeaders(['Authorization' => $token])
            ->asForm()
            ->post($url, [
                'target' => $phone,
                'message' => $message,
                'countryCode' => '62',
                'delay' => 2,
                'schedule' => 0,
            ]);

        if (!$response->successful()) {
            Log::error('Fonnte send failed', ['body' => $response->body()]);
        }

        return $response->successful();
    }
}
