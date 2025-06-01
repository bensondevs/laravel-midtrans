<?php

namespace Bensondevs\Midtrans\Contracts;

interface Customer
{
    public function asMidtransCustomer(): array;
}
