<?php

namespace Bensondevs\Midtrans\Models\Concerns;

use Bensondevs\Midtrans\Contracts\Customer;
use Bensondevs\Midtrans\Contracts\Subscribable;
use Bensondevs\Midtrans\Contracts\TransactionDetails;
use Bensondevs\Midtrans\Core\Api\Payment\RefundTransaction;
use Bensondevs\Midtrans\Core\Api\Snap\Charge;
use Bensondevs\Midtrans\Core\Api\Subscription\CreateSubscription;
use Bensondevs\Midtrans\Enums\Gopay\GopayPaymentOption;
use Bensondevs\Midtrans\Enums\PaymentType;
use Bensondevs\Midtrans\Models\Concerns\Billable\HasGopayAccounts;
use Bensondevs\Midtrans\Models\Concerns\Billable\HasRegisteredCards;

/**
 * @mixin Customer
 */
trait Billable
{
    use HasGopayAccounts;
    use HasRegisteredCards;

    /**
     * @throws \Exception
     */
    public function asMidtransCustomer(): array
    {
        return [
            'first_name' => $this->getMidtransFirstName(),
            'last_name' => $this->getMidtransLastName(),
            'email' => $this->getMidtransEmail(),
            'phone' => $this->getMidtransPhone(),
        ];
    }

    public function getMidtransFirstName(): ?string
    {
        return match (true) {
            isset($this->first_name) and filled($this->first_name) => $this->first_name,
            method_exists($this, method: 'getFirstName') and is_string($this->getFirstName()) and filled($this->getFirstName()) => $this->getFirstName(),
            method_exists($this, method: 'firstName') and is_string($this->firstName()) and filled($this->firstName()) => $this->firstName(),
            isset($this->name) and filled($this->name) => str($this->name)->explode(' ')[0],
            default => throw new \Exception('Missing first name'),
        };
    }

    public function getMidtransLastName(): ?string
    {
        return match (true) {
            isset($this->last_name) and filled($this->last_name) => $this->last_name,
            method_exists($this, method: 'getLastName') and is_string($this->getLastName()) and filled($this->getLastName()) => $this->getLastName(),
            method_exists($this, method: 'lastName') and is_string($this->lastName()) and filled($this->lastName()) => $this->lastName(),
            isset($this->name) and filled($this->name) => str($this->name)->explode(' ')[count(str($this->name)->explode(' ')) - 1],
            default => throw new \Exception('Missing last name'),
        };
    }

    public function getMidtransEmail(): ?string
    {
        return match (true) {
            isset($this->email) and filled($this->email) => $this->email,
            method_exists($this, method: 'getEmail') and is_string($this->getEmail()) and filled($this->getEmail()) => $this->getEmail(),
            method_exists($this, method: 'email') and is_string($this->email()) and filled($this->email()) => $this->email(),
            default => throw new \Exception('Missing email'),
        };
    }

    public function getMidtransPhone(): ?string
    {
        return match (true) {
            isset($this->phone) and filled($this->phone) => $this->phone,
            method_exists($this, method: 'getPhone') and is_string($this->getPhone()) and filled($this->getPhone()) => $this->getPhone(),
            method_exists($this, method: 'phone') and is_string($this->phone()) and filled($this->phone()) => $this->phone(),
            method_exists($this, method: 'getPhoneNumber') and is_string($this->getPhoneNumber()) and filled($this->getPhoneNumber()) => $this->getPhoneNumber(),
            method_exists($this, method: 'phoneNumber') and is_string($this->phoneNumber()) and filled($this->phoneNumber()) => $this->phoneNumber(),
            default => throw new \Exception('Missing phone'),
        };
    }

    /**
     * @throws \Exception
     */
    public function snapCharge(array $order): Charge
    {
        $charge = Charge::make($order)
            ->setCustomerDetails($this->asMidtransCustomer());

        $charge->send();

        return $charge;
    }

    public function refund(
        TransactionDetails $order,
        ?int $amount = null,
        ?string $reason = '',
    ): RefundTransaction {
        $refund = RefundTransaction::make($order->getMidtransOrderId());

        $amount ??= $order->getMidtransGrossAmount();
        $refund->setAmount($amount)
            ->setReason($reason)
            ->send();

        return $refund;
    }

    /**
     * @throws \Exception
     */
    public function subscribe(
        Subscribable $subscribable,
        PaymentType|string $paymentType,
        string $token,
        array $metadata = [],
    ): CreateSubscription {
        $subscribe = new CreateSubscription(
            name: $subscribable->getName(),
            amount: $subscribable->getPrice(),
            currency: $subscribable->getCurrency(),
            paymentType: $paymentType,
            token: $token,
            schedule: [
                'interval' => $subscribable->getInterval(),
                'interval_unit' => $subscribable->getIntervalUnit(),
                'max_interval' => $subscribable->getMaxInterval(),
                'start_time' => $subscribable->getStartTime(),
            ],
            retrySchedule: $subscribable->hasRetrySchedule() ? [
                'interval' => $subscribable->getInterval(),
                'interval_unit' => $subscribable->getIntervalUnit(),
                'max_interval' => $subscribable->getMaxInterval(),
            ] : [],
            metadata: array_merge($metadata, $subscribable->getMetadata()),
            customerDetails: $this->asMidtransCustomer(),
        );

        $subscribe->send();

        return $subscribe;
    }

    /**
     * @throws \Exception
     */
    public function gopaySubscribe(
        Subscribable $subscribable,
        GopayPaymentOption|string|null $paymentOption = '',
        array $metadata = [],
    ): CreateSubscription {
        return $this->subscribe(
            $subscribable,
            PaymentType::Gopay->getKey(),
            $this->getGopayToken($paymentOption),
            $metadata,
        );
    }
}
