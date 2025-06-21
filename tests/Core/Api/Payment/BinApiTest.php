<?php

use Bensondevs\Midtrans\Core\Api\Payment\BinApi;


it('can get valid BIN data', function () {
    $bin = BinApi::make('45563300');
    $bin->get();
    expect($bin->getResponseStatus())->toBe(200)
        ->toBeLessThan(300)
        ->and($bin->getData())->not->toBeEmpty();
});

it('fail to get BIN data if bin number is invalid', function () {
    $bin = BinApi::make('000000');
    $bin->get();
    expect($bin->getResponseStatus())->toBe(404)
        ->and($bin->getData())->toBeArray();
});

it('fail to get BIN data if bin number is not provided', function () {
    $bin = BinApi::make('');
    $bin->get();
    expect($bin->getResponseStatus())->toBe(404)
        ->and($bin->getData())->toBeArray();
});

it('fail to get BIN data if bin number is not a number', function () {
    $bin = BinApi::make('not-a-number');
    $bin->get();
    expect($bin->getResponseStatus())->toBe(404)
        ->and($bin->getData())->toBeArray();
});