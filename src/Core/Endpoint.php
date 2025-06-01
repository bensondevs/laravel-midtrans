<?php

namespace Bensondevs\Midtrans\Core;

use Bensondevs\Midtrans\Core\Concerns\HasMode;

class Endpoint
{
    use HasMode;

    public static function apiUrl(string $uri = ''): string
    {
        $mode = self::mode();

        $baseUrl = config("midtrans.$mode.api_url");

        return $baseUrl.$uri;
    }

    public static function chargeTransaction(): string
    {
        return self::apiUrl('v2/transactions');
    }

    public static function captureTransaction(): string
    {
        return self::apiUrl('v2/capture');
    }

    public static function cancelTransaction(string $transactionOrOderId): string
    {
        return self::apiUrl('v2/'.$transactionOrOderId.'/cancel');
    }

    public static function expireTransaction(string $transactionOrOderId): string
    {
        return self::apiUrl('v2/'.$transactionOrOderId.'/expire');
    }

    public static function refundTransaction(string $transactionOrOderId): string
    {
        return self::apiUrl('v2/'.$transactionOrOderId.'/refund');
    }

    public static function directRefundTransaction(string $transactionOrOderId): string
    {
        return self::apiUrl('v2/'.$transactionOrOderId.'/refund/online/direct');
    }

    public static function transactionStatus(string $transactionOrOderId): string
    {
        return self::apiUrl('v2/'.$transactionOrOderId.'/status');
    }

    public static function transactionStatusB2B(string $transactionOrOderId): string
    {
        return self::apiUrl('v2/'.$transactionOrOderId.'/status/b2b');
    }

    public static function registerCard(): string
    {
        return self::apiUrl('v2/card/register');
    }

    public static function createPayAccount(): string
    {
        return self::apiUrl('v2/pay/account');
    }

    public static function getPayAccount(string $accountId): string
    {
        return self::apiUrl('v2/pay/account/'.$accountId);
    }

    public static function unbindPayAccount(string $accountId): string
    {
        return self::apiUrl('v2/pay/account/'.$accountId.'/unbind');
    }

    public static function fetchPromotion(string $accountId): string
    {
        return self::apiUrl('v2/gopay/promo/'.$accountId);
    }

    public static function pointInquiry(string $tokenId): string
    {
        return self::apiUrl('v2/point_inquiry/'.$tokenId);
    }

    public static function binApi(string $binNumber): string
    {
        return self::apiUrl('v1/bins/'.$binNumber);
    }

    public static function createSubscription(): string
    {
        return self::apiUrl('v1/subscriptions/');
    }

    public static function snapUrl(string $uri = ''): string
    {
        $mode = self::mode();

        $baseUrl = config("midtrans.$mode.snap_url");

        return $baseUrl.$uri;
    }

    public static function snapTransactionUrl(): string
    {
        return self::snapUrl('v1/transactions');
    }
}
