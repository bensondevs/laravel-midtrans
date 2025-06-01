<?php

namespace Bensondevs\Midtrans\Models\Concerns\Billable;

use Bensondevs\Midtrans\Core\Api\Payment\CreatePayAccount;
use Bensondevs\Midtrans\Core\Api\Payment\GetPayAccount;
use Bensondevs\Midtrans\Enums\Gopay\GopayPaymentOption;
use Bensondevs\Midtrans\Enums\Gopay\GopayStatus;
use Bensondevs\Midtrans\Models\GopayAccount;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Mockery\Exception;

trait HasGopayAccounts
{
    public function createGopayAccount(string $redirectUrl = ''): CreatePayAccount
    {
        $createPayAccount = CreatePayAccount::make('gopay', [
            'phone_number' => $this->getMidtransPhone(),
            'country_code' => '+62',
            'redirect_url' => $redirectUrl,
        ]);

        $response = $createPayAccount->send();

        if ($createPayAccount->isFailed()) {
            throw new Exception($createPayAccount->getChannelResponseMessage());
        }

        $account = new GopayAccount;
        $account->holder()->associate($this);
        $account->account_id = $response['account_id'];
        $account->status = $response['status'];
        $account->is_main = $this->gopayAccounts()
            ->where('is_main', true)
            ->doesntExist();
        $account->save();

        return $createPayAccount;
    }

    public function getGopayActivationUrl(string $redirectUrl = ''): ?string
    {
        $createPayAccount = $this->createGopayAccount($redirectUrl);

        return $createPayAccount->getActivationLinkUrl();
    }

    public function getGopayActivationAppUrl(string $redirectUrl = ''): ?string
    {
        $createPayAccount = $this->createGopayAccount($redirectUrl);

        return $createPayAccount->getActivationLinkApp();
    }

    public function gopayAccounts(): MorphMany
    {
        return $this->morphMany(GopayAccount::class, 'holder');
    }

    public function getMainGopayAccount(): GopayAccount
    {
        $accounts = $this->gopayAccounts;

        $mainAccount = $this->gopayAccounts
            ->filter(fn (GopayAccount $account) => $account->isMain())
            ->first() ?? $accounts->first();

        if (! $mainAccount instanceof GopayAccount) {
            throw new Exception('Current instance does not have gopay account.');
        }

        return $mainAccount;
    }

    public function getGopayToken(GopayPaymentOption|string|null $paymentOption = ''): string
    {
        $mainAccount = $this->getMainGopayAccount();

        $accountId = $mainAccount->getAccountId();
        $response = once(fn (): ?array => GetPayAccount::make($accountId)->getResponseData());

        $accountStatus = $response['account_status'] ?? '';
        if (blank($accountStatus) or GopayStatus::ENABLED->isNot($accountStatus)) {
            throw new Exception('Gopay account with ID: '.$accountId.' is not enabled.');
        }

        $paymentOption = filled($paymentOption)
            ? (is_string($paymentOption) ? $paymentOption : $paymentOption->getKey())
            : $mainAccount->getDefaultPaymentOption()->getKey();

        $availablePaymentOptions = $response['metadata']['payment_options'] ?? [];
        if (blank($availablePaymentOptions)) {
            throw new Exception('Gopay payment options are missing.');
        }

        $selectedPaymentOption = collect($availablePaymentOptions)
            ->where('name', $paymentOption)
            ->where('active', true)
            ->first();

        $token = $selectedPaymentOption['token'] ?? '';

        if (blank($token)) {
            throw new Exception('Gopay payment option is missing the token.');
        }

        return $token;
    }
}
