<?php

namespace Bensondevs\Midtrans\Sample;

use Bensondevs\Midtrans\Contracts\Subscribable as MidtransSubscribable;
use Bensondevs\Midtrans\Models\Concerns\Subscribable;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model implements MidtransSubscribable
{
    use Subscribable;
}
