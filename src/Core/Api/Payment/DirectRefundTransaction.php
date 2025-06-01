<?php

namespace Bensondevs\Midtrans\Core\Api\Payment;

use Bensondevs\Midtrans\Core\Api\Concerns\InteractsWithMidtransApi;
use Bensondevs\Midtrans\Core\Endpoint;

class DirectRefundTransaction extends RefundTransaction
{
    use InteractsWithMidtransApi;

    protected function getApiEndpoint(): string
    {
        return Endpoint::directRefundTransaction($this->transactionOrOderId);
    }
}
