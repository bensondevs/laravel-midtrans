<?php

namespace Bensondevs\Midtrans\Contracts;

interface Order
{
    public function getTransactionId(): string;

    public function getGrossAmount(): int;

    /**
     * @return array<int, OrderItem>
     */
    public function getItemDetails(): array;
}
