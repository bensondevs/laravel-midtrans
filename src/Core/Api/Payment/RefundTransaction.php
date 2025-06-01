<?php

namespace Bensondevs\Midtrans\Core\Api\Payment;

use Bensondevs\Midtrans\Core\Api\Concerns\InteractsWithMidtransApi;
use Bensondevs\Midtrans\Core\Endpoint;

class RefundTransaction
{
    use InteractsWithMidtransApi;

    public function __construct(
        protected string $transactionOrOderId,
        protected ?string $refundKey = null,
        protected ?int $amount = null,
        protected ?string $reason = null,
    ) {}

    public static function make(
        string $transactionOrOderId,
        ?string $refundKey = null,
        ?int $amount = null,
        ?string $reason = null,
    ): self {
        return new self(
            $transactionOrOderId,
            $refundKey,
            $amount,
            $reason,
        );
    }

    public function setRefundKey(string $refundKey): static
    {
        $this->refundKey = $refundKey;

        return $this;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function setReason(string $reason): static
    {
        $this->reason = $reason;

        return $this;
    }

    protected function getApiEndpoint(): string
    {
        return Endpoint::refundTransaction($this->transactionOrOderId);
    }

    protected function getPayloadData(): array
    {
        return [
            'refund_key' => $this->refundKey,
            'amount' => $this->amount,
            'reason' => $this->reason,
        ];
    }

    public function isRefundSuccess(): bool
    {
        if (! $this->response?->successful()) {
            return false;
        }

        $responseData = $this->getResponseData();
        $transactionStatus = $responseData['transaction_status'] ?? '';

        return in_array($transactionStatus, ['refund', 'partial_refund']);
    }

    public function isRefundRejected(): bool
    {
        if (! $this->response?->successful()) {
            return false;
        }

        $responseData = $this->getResponseData();
        $transactionStatus = $responseData['transaction_status'] ?? '';

        return $transactionStatus === 'settlement';
    }
}
