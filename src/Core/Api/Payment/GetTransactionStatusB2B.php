<?php

namespace Bensondevs\Midtrans\Core\Api\Payment;

use Bensondevs\Midtrans\Core\Api\Concerns\InteractsWithMidtransApi;
use Bensondevs\Midtrans\Core\Endpoint;

class GetTransactionStatusB2B
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
        return Endpoint::transactionStatusB2B($this->transactionOrOderId);
    }

    protected function getPayloadData(): array
    {
        return [];
    }

    public function getTransactions(): array
    {
        $transactions = $this->getResponseAttribute('transactions', []);

        if (! is_array($transactions)) {
            return [];
        }

        return $transactions;
    }
}
