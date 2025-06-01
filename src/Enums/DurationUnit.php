<?php

namespace Bensondevs\Midtrans\Enums;

use Bensondevs\Midtrans\Enums\Concerns\EnumExtensions;

enum DurationUnit: string
{
    use EnumExtensions;

    case Second = 'second';

    case Minute = 'minute';

    case Hour = 'hour';

    case Day = 'day';
}
