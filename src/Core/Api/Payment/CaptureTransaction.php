<?php

namespace Bensondevs\Midtrans\Core\Api\Payment;

use Bensondevs\Midtrans\Core\Api\Concerns\InteractsWithMidtransApi;
use Bensondevs\Midtrans\Core\Endpoint;

class CaptureTransaction
{
    use InteractsWithMidtransApi;

    public function __construct(
        protected string $transactionId,
        protected int $grossAmount,
    ) {}

    public static function make(string $transactionId, int $grossAmount): static
    {
        return new CaptureTransaction($transactionId, $grossAmount);
    }

    protected function getApiEndpoint(): string
    {
        return Endpoint::captureTransaction();
    }

    protected function getPayloadData(): array
    {
        return [
            'transaction_id' => $this->transactionId,
            'gross_amount' => $this->grossAmount,
        ];
    }
}
