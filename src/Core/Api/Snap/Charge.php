<?php

namespace Bensondevs\Midtrans\Core\Api\Snap;

use Bensondevs\Midtrans\Core\Api\Concerns\HasCustomerDetails;
use Bensondevs\Midtrans\Core\Api\Concerns\InteractsWithMidtransApi;
use Bensondevs\Midtrans\Core\Endpoint;

class Charge
{
    use HasCustomerDetails;
    use InteractsWithMidtransApi;

    public function __construct(
        protected ?array $transactionDetails = null,
        protected ?array $itemDetails = null,
        protected ?array $customerDetails = null,
        protected ?array $enabledPayments = null,
        protected ?array $creditCard = null,
        protected ?array $bcaVa = null,
        protected ?array $permataVa = null,
        protected ?array $bniVa = null,
        protected ?array $cimbVa = null,
        protected ?array $briVa = null,
        protected ?array $gopay = null,
        protected ?array $shopeepay = null,
        protected ?array $callbacks = null,
        protected ?array $expiry = null,
        protected ?array $pageExpiry = null,
        protected ?string $customField1 = null,
        protected ?string $customField2 = null,
        protected ?string $customField3 = null,
        protected ?array $recurring = null,
    ) {}

    public static function make(array $transactionDetails): static
    {
        return new static(transactionDetails: $transactionDetails);
    }

    protected function getApiEndpoint(): string
    {
        return Endpoint::snapTransactionUrl();
    }

    protected function getPayloadData(): array
    {
        return array_filter(array: [
            'transaction_details' => $this->transactionDetails,
            'item_details' => $this->itemDetails,
            'enabled_payments' => $this->enabledPayments,
            'credit_card' => $this->creditCard,
            'bca_va' => $this->bcaVa,
            'permata_va' => $this->permataVa,
            'bni_va' => $this->bniVa,
            'cimb_va' => $this->cimbVa,
            'bri_va' => $this->briVa,
            'gopay' => $this->gopay,
            'shopeepay' => $this->shopeepay,
            'callbacks' => $this->callbacks,
            'expiry' => $this->expiry,
            'page_expiry' => $this->pageExpiry,
            'custom_field1' => $this->customField1,
            'custom_field2' => $this->customField2,
            'custom_field3' => $this->customField3,
            'recurring' => $this->recurring,
        ], callback: fn (mixed $value) => ! is_null($value));
    }
}
