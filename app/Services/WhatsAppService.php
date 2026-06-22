<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Send a WhatsApp message to a specific phone number.
     *
     * @param string $phone The recipient's phone number.
     * @param string $message The message content.
     * @param string|null $imageUrl Optional image URL to attach.
     * @return bool
     */
    public function sendMessage(string $phone, string $message, ?string $imageUrl = null): bool
    {
        // Format the phone number (e.g., ensure it starts with country code, remove spaces/plus)
        $formattedPhone = $this->formatPhoneNumber($phone);

        if (!$formattedPhone) {
            Log::warning("WhatsAppService: Invalid phone number provided.", ['phone' => $phone]);
            return false;
        }

        $apiUrl = rtrim(env('EVOLUTION_API_URL', ''), '/');
        $instance = env('EVOLUTION_API_INSTANCE', '');
        $apiKey = env('EVOLUTION_API_KEY', '');

        if (empty($apiUrl) || empty($instance) || empty($apiKey)) {
            Log::error("WhatsAppService: Evolution API credentials not configured in .env");
            return false;
        }

        try {
            if ($imageUrl) {
                // Send Media Message
                $endpoint = "{$apiUrl}/message/sendMedia/{$instance}";
                $payload = [
                    'number' => $formattedPhone,
                    'options' => [
                        'delay' => 1200,
                        'presence' => 'composing'
                    ],
                    'mediaMessage' => [
                        'mediatype' => 'image',
                        'caption' => $message,
                        'media' => $imageUrl
                    ]
                ];
            } else {
                // Send Text Message
                $endpoint = "{$apiUrl}/message/sendText/{$instance}";
                $payload = [
                    'number' => $formattedPhone,
                    'options' => [
                        'delay' => 1200,
                        'presence' => 'composing'
                    ],
                    'textMessage' => [
                        'text' => $message
                    ]
                ];
            }

            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'apikey' => $apiKey
            ])->post($endpoint, $payload);

            if ($response->successful()) {
                Log::info("WhatsAppService: Message sent successfully to {$formattedPhone} via Evolution API.");
                return true;
            }

            Log::error("WhatsAppService: Failed to send message via Evolution API.", [
                'phone' => $formattedPhone,
                'status' => $response->status(),
                'response' => $response->json()
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error("WhatsAppService: Exception when sending message via Evolution API: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Helper to format phone numbers to international format without + or spaces.
     */
    protected function formatPhoneNumber(string $phone): ?string
    {
        $cleaned = preg_replace('/[^0-9]/', '', $phone);

        if (empty($cleaned)) {
            return null;
        }

        // Example for Bangladesh: if it starts with 01, prepend 88
        if (strlen($cleaned) === 11 && str_starts_with($cleaned, '01')) {
            return '88' . $cleaned;
        }

        return $cleaned;
    }
}
