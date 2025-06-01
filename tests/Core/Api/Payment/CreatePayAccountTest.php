<?php

use Bensondevs\Midtrans\Core\Api\Payment\CreatePayAccount;
use Bensondevs\Midtrans\Enums\PaymentType;

it('can create a GoPay partner pay account', function () {
    $createPayAccount = CreatePayAccount::make(PaymentType::Gopay->getKey())
        ->setGopayPartnerPhoneNumber('1234500015')
        ->setGopayPartnerCountryCode('62')
        ->setGopayPartnerRedirectUrl('https://www.gojek.com');

    $response = $createPayAccount->send();
    dd($response);

    expect($createPayAccount->getResponseStatus())->toBe(200);

    /*expect($createPayAccount->getResponseStatus())->toBe(201)
        ->and($createPayAccount->isSuccess())->toBeTrue()
        ->and($createPayAccount->getAccountId())->not->toBeEmpty()
        ->and($createPayAccount->getAccountStatus())->toBe('PENDING')
        ->and($createPayAccount->getActivationLinkUrl())->toContain('http')
        ->and($createPayAccount->getActivationLinkApp())->toContain('http');*/
});
