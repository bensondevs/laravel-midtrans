<?php

namespace Bensondevs\Midtrans\Core\Api\Payment;

use Bensondevs\Midtrans\Core\Api\Concerns\InteractsWithMidtransApi;
use Bensondevs\Midtrans\Core\Endpoint;

class GetPayAccount
{
    use InteractsWithMidtransApi;

    public function __construct(protected string $accountId)
    {
        //
    }

    public static function make(string $accountId): static
    {
        $gopayAccount = new self($accountId);
        $gopayAccount->get();

        return $gopayAccount;
    }

    protected function getApiEndpoint(): string
    {
        return Endpoint::getPayAccount($this->accountId);
    }

    protected function getPayloadData(): array
    {
        return [];
    }

    public function getAccountStatus(): ?string
    {
        return $this->getResponseAttribute('account_status', '');
    }

    public function isPending(): bool
    {
        return $this->getAccountStatus() === 'PENDING';
    }

    public function isExpired(): bool
    {
        return $this->getAccountStatus() === 'EXPIRED';
    }

    public function isEnabled(): bool
    {
        return $this->getAccountStatus() === 'ENABLED';
    }

    public function isDisabled(): bool
    {
        return $this->getAccountStatus() === 'DISABLED';
    }
}
