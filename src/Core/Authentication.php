<?php

namespace Bensondevs\Midtrans\Core;

use Bensondevs\Midtrans\Core\Concerns\HasMode;
use Exception;

class Authentication
{
    use HasMode;

    /**
     * @throws Exception
     */
    public static function bearerToken(): string
    {
        $mode = self::mode();

        if (! $serverKey = config("midtrans.$mode.server_key")) {
            throw new Exception('Payment server key not found.');
        }

        return base64_encode("$serverKey:");
    }

    /**
     * @throws Exception
     */
    public static function basicAuthHeader(): string
    {
        return 'Basic '.self::bearerToken();
    }

    /**
     * @throws Exception
     */
    public static function apiHeaders(): array
    {
        return [
            'Authorization' => self::basicAuthHeader(),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    public static function serverKey(): string
    {
        $mode = self::mode();

        return config("midtrans.$mode.server_key");
    }

    public static function clientKey(): string
    {
        $mode = self::mode();

        return config("midtrans.$mode.client_key");
    }

    public static function verifyWebhookPayload(array $payload): bool
    {
        $orderId = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $givenSignature = $payload['signature_key'] ?? null;

        if (blank($orderId) || blank($statusCode) || blank($grossAmount) || blank($givenSignature)) {
            return false;
        }

        $serverKey = self::serverKey();
        $expectedSignature = hash('sha256', $orderId.$statusCode.$grossAmount.$serverKey);

        return hash_equals($expectedSignature, $givenSignature);
    }
}
