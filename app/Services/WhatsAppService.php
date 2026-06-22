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

        /*
         * ---------------------------------------------------------
         * TODO: API INTEGRATION
         * ---------------------------------------------------------
         * Replace this log statement with an actual HTTP request to
         * your chosen WhatsApp API Provider (Twilio, Meta, GreenAPI, etc.)
         *
         * Example using Http facade:
         * Http::withToken(env('WHATSAPP_TOKEN'))->post('https://api.provider.com/send', [
         *     'phone' => $formattedPhone,
         *     'message' => $message,
         *     'media_url' => $imageUrl
         * ]);
         */

        Log::info("WhatsAppService: [MOCK SEND]", [
            'to' => $formattedPhone,
            'message' => $message,
            'image' => $imageUrl
        ]);

        return true;
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
