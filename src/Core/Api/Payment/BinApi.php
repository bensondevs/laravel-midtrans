<?php

namespace Bensondevs\Midtrans\Core\Api\Payment;

use Bensondevs\Midtrans\Core\Api\Concerns\InteractsWithMidtransApi;
use Bensondevs\Midtrans\Core\Endpoint;

class BinApi
{
    use InteractsWithMidtransApi;

    public function __construct(protected string $binNumber) {}

    public static function make(string $binNumber): static
    {
        return new self($binNumber);
    }

    protected function getApiEndpoint(): string
    {
        return Endpoint::binApi($this->binNumber);
    }

    protected function getPayloadData(): array
    {
        return [];
    }

    public function getData(): array
    {
        return $this->getResponseAttribute('data', []);
    }
}
