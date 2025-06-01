<?php

namespace Bensondevs\Midtrans\Core\Api\Subscription;

use Bensondevs\Midtrans\Core\Api\Concerns\InteractsWithMidtransApi;
use Bensondevs\Midtrans\Core\Endpoint;
use Bensondevs\Midtrans\Enums\PaymentType;

class CreateSubscription
{
    use InteractsWithMidtransApi;

    public function __construct(
        public string $name,
        public string $amount,
        public string $currency,
        public string $paymentType = 'credit_card',
        public string $token = '',
        public string $accountId = '',
        public array $schedule = [],
        public array $retrySchedule = [],
        public array $metadata = [],
        public array $customerDetails = [],
    ) {}

    public static function make(
        string $name,
        string $amount,
        string $currency,
        string $paymentType = 'credit_card',
        string $token = '',
        string $accountId = '',
        array $schedule = [],
        array $retrySchedule = [],
        array $metadata = [],
        array $customerDetails = [],
    ): static {
        return new static(
            $name,
            $amount,
            $currency,
            $paymentType,
            $token,
            $accountId,
            $schedule,
            $retrySchedule,
            $metadata,
            $customerDetails,
        );
    }

    protected function getApiEndpoint(): string
    {
        return Endpoint::createSubscription();
    }

    protected function getPayloadData(): array
    {
        return array_filter([
            'name' => $this->name,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'payment_type' => $this->paymentType,
            'token' => $this->token,
            'gopay' => $this->paymentType === PaymentType::Gopay->getKey() ? [
                'account_id' => $this->accountId,
            ] : [],
            'schedule' => $this->schedule,
            'retry_schedule' => $this->retrySchedule,
            'metadata' => $this->metadata,
            'customer_details' => $this->customerDetails,
        ], fn (mixed $value) => filled($value));
    }
}
