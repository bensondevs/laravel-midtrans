<?php

namespace Bensondevs\Midtrans\Core\Api\Payment;

use Bensondevs\Midtrans\Core\Api\Concerns\InteractsWithMidtransApi;
use Bensondevs\Midtrans\Core\Endpoint;

class CreatePayAccount
{
    use InteractsWithMidtransApi;

    public function __construct(
        protected string $paymentType,
        protected array $gopayPartner,
    ) {
        //
    }

    public static function make(string $paymentType, array $gopayPartner = []): static
    {
        return new static($paymentType, $gopayPartner);
    }

    public function setPaymentType(string $paymentType): static
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    public function setGopayPartner(array $gopayPartner): static
    {
        $this->gopayPartner = $gopayPartner;

        return $this;
    }

    public function setGopayPartnerPhoneNumber(string $phoneNumber): static
    {
        $this->gopayPartner['phone_number'] = $phoneNumber;

        return $this;
    }

    public function setGopayPartnerCountryCode(string $countryCode): static
    {
        $this->gopayPartner['country_code'] = $countryCode;

        return $this;
    }

    public function setGopayPartnerRedirectUrl(string $redirectUrl): static
    {
        $this->gopayPartner['redirect_url'] = $redirectUrl;

        return $this;
    }

    protected function getApiEndpoint(): string
    {
        return Endpoint::createPayAccount();
    }

    protected function getPayloadData(): array
    {
        return [
            'payment_type' => $this->paymentType,
            'gopay_partner' => $this->gopayPartner,
        ];
    }

    public function isSuccess(): bool
    {
        return $this->getResponseAttribute('status_code', '') === '201';
    }

    public function isFailed(): bool
    {
        return $this->getResponseAttribute('status_code', '') === '202';
    }

    public function getPaymentType()
    {
        return $this->getResponseAttribute('payment_type', '');
    }

    public function getChannelResponseCode(): ?string
    {
        if (! $this->isFailed()) {
            return '';
        }

        return $this->getResponseAttribute('channel_response_code', '');
    }

    public function getChannelResponseMessage(): ?string
    {
        if (! $this->isFailed()) {
            return '';
        }

        return $this->getResponseAttribute('channel_response_message', '');
    }

    public function getAccountId(): ?string
    {
        return $this->getResponseAttribute('account_id', '');
    }

    public function getAccountStatus(): ?string
    {
        return $this->getResponseAttribute('account_status', '');
    }

    public function getActions(): ?array
    {
        return $this->getResponseAttribute('actions', []);
    }

    public function getActivationLinkUrl(): ?string
    {
        $actions = $this->getActions();

        if (! is_array($actions)) {
            return '';
        }

        $name = 'activation-link-url';

        return collect($actions)->first(
            fn (array $action): bool => $action['name'] === $name,
        )['url'] ?? null;
    }

    public function getActivationLinkApp(): ?string
    {
        $actions = $this->getActions();

        if (! is_array($actions)) {
            return '';
        }

        $name = 'activation-link-app';

        return collect($actions)->first(
            fn (array $action): bool => $action['name'] === $name,
        )['url'] ?? null;
    }
}
