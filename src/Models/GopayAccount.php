<?php

namespace Bensondevs\Midtrans\Models;

use Bensondevs\Midtrans\Enums\Gopay\GopayPaymentOption;
use Bensondevs\Midtrans\Enums\Gopay\GopayStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class GopayAccount extends Model
{
    public function casts(): array
    {
        return [
            'status' => GopayStatus::class,
            'default_payment_option' => GopayPaymentOption::class,
        ];
    }

    public static function findByAccountId(string $accountId): ?self
    {
        return self::query()
            ->where('account_id', $accountId)
            ->first();
    }

    public function holder(): MorphTo
    {
        return $this->morphTo();
    }

    public function getAccountId(): string
    {
        return $this->account_id;
    }

    public function isMain(): bool
    {
        return boolval($this->is_main);
    }

    public function setAsMain(): bool
    {
        self::query()
            ->whereBelongsTo($this->holder, 'holder')
            ->update(['is_main' => false]);

        return $this->update(['is_main' => true]);
    }

    public function getDefaultPaymentOption(): GopayPaymentOption
    {
        return GopayPaymentOption::findOrDefault($this->default_payment_option);
    }
}
