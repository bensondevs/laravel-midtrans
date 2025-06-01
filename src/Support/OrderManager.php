<?php

namespace Bensondevs\Midtrans\Support;

use Bensondevs\Midtrans\Contracts\Order;

class OrderManager
{
    public function __construct(protected Order $order) {}

    public static function make(Order $order): OrderManager
    {
        return new OrderManager($order);
    }
}
