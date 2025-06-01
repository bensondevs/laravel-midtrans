<?php

namespace Bensondevs\Midtrans\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegisteredCard extends Model
{
    use SoftDeletes;

    public function holder(): MorphTo
    {
        return $this->morphTo();
    }

    public function getTokenId(): string
    {
        return $this->token_id;
    }
}
