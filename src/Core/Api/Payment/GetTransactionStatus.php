<?php

namespace Bensondevs\Midtrans\Core\Api\Payment;

use Bensondevs\Midtrans\Core\Api\Concerns\InteractsWithMidtransApi;
use Bensondevs\Midtrans\Core\Endpoint;

class GetTransactionStatus
{
    use InteractsWithMidtransApi;

    public function __construct(protected string $transactionOrOderId) {}

    public static function make(string $transactionOrOderId): static
    {
        $status = new self($transactionOrOderId);

        $status->get();

        return $status;
    }

    protected function getApiEndpoint(): string
    {
        return Endpoint::transactionStatus($this->transactionOrOderId);
    }

    protected function getPayloadData(): array
    {
        return [];
    }

    public function getTransactionStatus(): string
    {
        return strval($this->getResponseAttribute('transaction_status'));
    }

    public function isTransactionSuccess(): bool
    {
        return $this->getTransactionStatus() === 'capture';
    }

    public function isTransactionRefunded(): bool
    {
        return $this->getTransactionStatus() === 'refund';
    }

    public function getRefunds(): ?array
    {
        return $this->getResponseData()['refunds'] ?? [];
    }
}
