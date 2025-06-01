<?php

namespace Bensondevs\Midtrans\Core\Api\Payment;

use Bensondevs\Midtrans\Core\Api\Concerns\InteractsWithMidtransApi;
use Bensondevs\Midtrans\Core\Endpoint;
use Bensondevs\Midtrans\Enums\PaymentType;

class ChargeTransaction
{
    use InteractsWithMidtransApi;

    public function __construct(
        protected ?PaymentType $paymentType = null,
        protected ?array $transactionDetails = null,
        protected ?array $itemDetails = null,
        protected ?array $customerDetails = null,
        protected ?string $customField1 = null,
        protected ?string $customField2 = null,
        protected ?string $customField3 = null,
        protected ?array $customExpiry = null,
        protected ?array $metadata = [],
        protected array $extra = [],
    ) {}

    public static function make(
        PaymentType|string|null $paymentType = null,
        ?array $transactionDetails = null,
    ): static {
        return new static(
            paymentType: $paymentType ? PaymentType::findOrDefault($paymentType) : null,
            transactionDetails: $transactionDetails,
        );
    }

    protected function getApiEndpoint(): string
    {
        return Endpoint::chargeTransaction();
    }

    protected function getPayloadData(): array
    {
        $basePayload = [
            'payment_type' => PaymentType::findOrDefault($this->paymentType)->getKey(),
            'transaction_details' => $this->transactionDetails,
            'item_details' => $this->itemDetails,
            'customer_details' => $this->customerDetails,
            'custom_field1' => $this->customField1,
            'custom_field2' => $this->customField2,
            'custom_field3' => $this->customField3,
            'custom_expiry' => $this->customExpiry,
            'metadata' => $this->metadata,
        ];

        $extraPayload = collect($this->extra)
            ->filter(fn (mixed $value): bool => filled($value))
            ->mapWithKeys(fn (mixed $value, string|int $key): array => [
                str((string) $key)->snake()->toString() => $value,
            ])
            ->all();

        return array_filter(
            array_merge($basePayload, $extraPayload),
            fn (mixed $value): bool => filled($value),
        );
    }
}
