<?php

namespace Bensondevs\Midtrans\Core\Api\Payment;

use Bensondevs\Midtrans\Core\Api\Concerns\InteractsWithMidtransApi;
use Bensondevs\Midtrans\Core\Endpoint;

class PointInquiry
{
    use InteractsWithMidtransApi;

    public function __construct(
        protected string $tokenId,
        protected ?string $grossAmount = null,
    ) {}

    public static function make(
        string $tokenId,
        ?string $grossAmount = null,
    ): static {
        return new self($tokenId, $grossAmount);
    }

    protected function getApiEndpoint(): string
    {
        return Endpoint::pointInquiry($this->tokenId);
    }

    protected function getPayloadData(): array
    {
        return [
            'gross_amount' => $this->grossAmount,
        ];
    }

    public function getPointBalanceAmount(): ?string
    {
        return $this->getResponseAttribute('point_balance_amount', '');
    }
}
