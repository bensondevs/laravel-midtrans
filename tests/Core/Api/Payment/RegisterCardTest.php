<?php

use Bensondevs\Midtrans\Core\Api\Payment\RegisterCard;

it('can register a credit card via midtrans sandbox', function () {
    $registerCard = RegisterCard::make(
        cardNumber: '4617006959746656',
        cardExpirationMonth: '12',
        cardExpirationYear: now()->addYear()->format('Y'),
    );

    expect($registerCard->getResponseStatus())->toBe(200)
        ->and($registerCard->getSavedTokenId())->not()->toBeEmpty()
        ->and($registerCard->getTransactionId())->not()->toBeEmpty()
        ->and($registerCard->getMaskedCard())->toBe('46170069-6656');
});