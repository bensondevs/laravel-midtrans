<?php

use Bensondevs\Midtrans\Core\Api\Payment\ChargeTransaction;

it('can charge transaction properly', function () {
    $chargeTransaction = ChargeTransaction::make(transactionDetails: [
        'orderId' => now()->timestamp,
        'grossAmount' => 100_000,
    ]);
    $chargeTransaction->send();
    dd($chargeTransaction);

    expect($chargeTransaction->getResponseStatus())->toBe(200);

    $response = $chargeTransaction->getResponseData();
    expect($response['status_code'])->toBe('200');
});
