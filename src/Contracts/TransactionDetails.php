<?php

namespace Bensondevs\Midtrans\Contracts;

interface TransactionDetails
{
    public function getMidtransOrderId(): string;

    public function getMidtransGrossAmount(): int;
}
