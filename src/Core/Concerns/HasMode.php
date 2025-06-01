<?php

namespace Bensondevs\Midtrans\Core\Concerns;

trait HasMode
{
    public static function mode(): string
    {
        $mode = str(config('services.midtrans.mode', 'sandbox'))
            ->lower()
            ->toString();

        return in_array($mode, ['sandbox', 'production']) ? $mode : 'sandbox';
    }
}
