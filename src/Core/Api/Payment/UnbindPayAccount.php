<?php

namespace Bensondevs\Midtrans\Core\Api\Payment;

use Bensondevs\Midtrans\Core\Api\Concerns\InteractsWithMidtransApi;
use Bensondevs\Midtrans\Core\Endpoint;

class UnbindPayAccount
{
    use InteractsWithMidtransApi;

    public function __construct(protected string $accountId) {}

    public static function make(string $accountId): static
    {
        return new self($accountId);
    }

    protected function getApiEndpoint(): string
    {
        return Endpoint::unbindPayAccount($this->accountId);
    }

    protected function getPayloadData(): array
    {
        return [];
    }
}
