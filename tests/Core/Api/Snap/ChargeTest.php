<?php

use Bensondevs\Midtrans\Core\Api\Snap\Charge;

it('can send a real snap charge request to midtrans sandbox', function () {
    $charge = Charge::make([
        'order_id' => 'ORDER-' . now()->timestamp,
        'gross_amount' => 100_000,
    ]);

    $charge->send();

    expect($charge->getResponseStatus())
        ->toBeGreaterThanOrEqual(200)
        ->toBeLessThan(300)
        ->and($data = $charge->getResponseData())
        ->toHaveKey('token')
        ->toHaveKey('redirect_url')
        ->and($data['redirect_url'])->toContain('midtrans.com/snap');
});

it('fails with invalid gross amount', function () {
    $charge = Charge::make([
        'order_id' => 'ORDER-' . now()->timestamp,
        'gross_amount' => -100, // invalid
    ]);

    $charge->send();

    expect($charge->getResponseStatus())->toBeGreaterThanOrEqual(400);
});
