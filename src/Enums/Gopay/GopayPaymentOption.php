<?php

namespace Bensondevs\Midtrans\Enums\Gopay;

use Bensondevs\Midtrans\Enums\Concerns\EnumExtensions;

enum GopayPaymentOption: string
{
    use EnumExtensions;

    case GOPAY_WALLET = 'GOPAY_WALLET';
    case PAY_LATER = 'PAY_LATER';
}
