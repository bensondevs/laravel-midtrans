<?php

namespace Bensondevs\Midtrans\Sample;

use Bensondevs\Midtrans\Contracts\Customer as MidtransCustomer;
use Bensondevs\Midtrans\Models\Concerns\Billable as MidtransBillable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements MidtransCustomer
{
    use MidtransBillable;
}
