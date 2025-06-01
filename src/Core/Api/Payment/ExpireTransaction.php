<?php

namespace Bensondevs\Midtrans\Core\Api\Payment;

use Bensondevs\Midtrans\Core\Api\Concerns\InteractsWithMidtransApi;
use Bensondevs\Midtrans\Core\Endpoint;

class ExpireTransaction
{
    use InteractsWithMidtransApi;

    public function __construct(
        protected string $transactionOrOderId,
    ) {}

    public static function make(string $transactionOrOderId): self
    {
        return new self($transactionOrOderId);
    }

    protected function getApiEndpoint(): string
    {
        return Endpoint::expireTransaction($this->transactionOrOderId);
    }

    protected function getPayloadData(): array
    {
        return [];
    }
}
