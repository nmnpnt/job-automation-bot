<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Send a WhatsApp message to a user based on their notification preferences.
     */
    public function send(User $user, string $message): bool
    {
        $prefs = $user->notificationPreferences;
        if (!$prefs || !$prefs->channel_whatsapp) {
            return false;
        }

        $phone = preg_replace('/[^0-9]/', '', $prefs->whatsapp_phone_number ?? '');
        $apiKey = trim($prefs->whatsapp_api_key ?? '');
        $provider = $prefs->whatsapp_provider ?? 'callmebot';

        if (empty($phone)) {
            Log::warning("WhatsApp notification skipped for User {$user->id}: No phone number provided.");
            return false;
        }

        try {
            if ($provider === 'callmebot') {
                if (empty($apiKey)) {
                    Log::warning("WhatsApp notification skipped for User {$user->id}: CallMeBot API key missing.");
                    return false;
                }

                // CallMeBot Free API
                $url = "https://api.callmebot.com/whatsapp.php";
                $response = Http::timeout(10)->get($url, [
                    'phone' => $phone,
                    'text' => $message,
                    'apikey' => $apiKey,
                ]);

                if ($response->successful()) {
                    Log::info("WhatsApp message successfully sent to {$phone} via CallMeBot.");
                    return true;
                } else {
                    Log::error("CallMeBot error: " . $response->body());
                    return false;
                }
            } elseif ($provider === 'custom_webhook') {
                // Custom Webhook Endpoint (e.g. Twilio / UltraMsg / WhatsApp Gateway)
                if (empty($apiKey)) {
                    Log::warning("WhatsApp webhook URL missing for User {$user->id}.");
                    return false;
                }

                $response = Http::timeout(10)->post($apiKey, [
                    'phone' => $phone,
                    'message' => $message,
                    'timestamp' => now()->toIso8601String(),
                ]);

                return $response->successful();
            }

            return false;
        } catch (\Throwable $e) {
            Log::error("WhatsApp Notification failed for User {$user->id}: " . $e->getMessage());
            return false;
        }
    }
}
