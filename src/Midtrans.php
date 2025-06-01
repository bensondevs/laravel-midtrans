<?php

namespace Bensondevs\Midtrans;

use Bensondevs\Midtrans\Core\Api\Snap\Charge;

class Midtrans
{
    public static function snapTransaction(
        ?array $transactionDetails = null,
        ?array $itemDetails = null,
        ?array $customerDetails = null,
        ?array $enabledPayments = null,
        ?array $creditCard = null,
        ?array $bcaVa = null,
        ?array $permataVa = null,
        ?array $bniVa = null,
        ?array $cimbVa = null,
        ?array $briVa = null,
        ?array $gopay = null,
        ?array $shopeepay = null,
        ?array $callbacks = null,
        ?array $expiry = null,
        ?array $pageExpiry = null,
        ?string $customField1 = null,
        ?string $customField2 = null,
        ?string $customField3 = null,
        ?array $recurring = null,
    ): Charge {
        return new Charge(
            transactionDetails: $transactionDetails,
            itemDetails: $itemDetails,
            customerDetails: $customerDetails,
            enabledPayments: $enabledPayments,
            creditCard: $creditCard,
            bcaVa: $bcaVa,
            permataVa: $permataVa,
            bniVa: $bniVa,
            cimbVa: $cimbVa,
            briVa: $briVa,
            gopay: $gopay,
            shopeepay: $shopeepay,
            callbacks: $callbacks,
            expiry: $expiry,
            pageExpiry: $pageExpiry,
            customField1: $customField1,
            customField2: $customField2,
            customField3: $customField3,
            recurring: $recurring,
        );
    }
}
