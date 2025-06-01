<?php

namespace Bensondevs\Midtrans\Enums\Gopay;

use Bensondevs\Midtrans\Enums\Concerns\EnumExtensions;

enum GopayStatus: string
{
    use EnumExtensions;

    case PENDING = 'PENDING';
    case EXPIRED = 'EXPIRED';
    case ENABLED = 'ENABLED';
    case DISABLED = 'DISABLED';
}
