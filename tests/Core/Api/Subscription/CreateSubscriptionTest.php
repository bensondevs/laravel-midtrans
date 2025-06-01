<?php

use Bensondevs\Midtrans\Core\Api\Subscription\CreateSubscription;
use Bensondevs\Midtrans\Enums\PaymentType;

it('can create a subscription on midtrans using credit card', function () {
    $subscription = CreateSubscription::make(
        name: fake()->name(),
        amount: '100000',
        currency: 'IDR',
        paymentType: PaymentType::CreditCard->getKey(),
        token: '48111111sHfSakAvHvFQFEjTivUV1114',
        schedule: [
            'interval' => 1,
            'interval_unit' => 'month',
            'max_interval' => 12,
        ],
        retrySchedule: [
            'interval' => 1,
            'interval_unit' => 'day',
            'max_interval' => 3,
        ],
        customerDetails: [
            'first_name' => 'Simeon',
            'last_name' => 'Bensona',
            'email' => 'benson@exclolab.com',
            'phone' => '+62812345678',
        ],
    );

    $response = $subscription->send();

    expect($subscription->getResponseStatus())
        ->toBeGreaterThanOrEqual(200)
        ->toBeLessThan(300)
        ->and($response)
        ->toHaveKey('id')
        ->toHaveKey('status')
        ->and($response['status'])->toBe('active');
});

it('can create a subscription on midtrans using gopay account', function () {
    $subscription = CreateSubscription::make(
        name: fake()->name(),
        amount: '100000',
        currency: 'IDR',
        paymentType: PaymentType::Gopay->getKey(),
        token: 'eyJ0eXBlIjogIkdPUEFZX1dBTExFVCIsICJpZCI6ICIifQ==',
        accountId: '00000269-7836-49e5-bc65-e592afafec14',
        schedule: [
            'interval' => 1,
            'interval_unit' => 'month',
            'max_interval' => 12,
        ],
        retrySchedule: [
            'interval' => 1,
            'interval_unit' => 'day',
            'max_interval' => 3,
        ],
        customerDetails: [
            'first_name' => 'Simeon',
            'last_name' => 'Bensona',
            'email' => 'benson@exclolab.com',
            'phone' => '+62812345678',
        ],
    );

    $response = $subscription->send();
    dd($response);

    expect($subscription->getResponseStatus())
        ->toBeGreaterThanOrEqual(200)
        ->toBeLessThan(300)
        ->and($response)
        ->toHaveKey('id')
        ->toHaveKey('status')
        ->and($response['status'])->toBe('active');
});
