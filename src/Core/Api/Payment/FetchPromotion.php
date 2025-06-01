<?php

namespace Bensondevs\Midtrans\Core\Api\Payment;

use Bensondevs\Midtrans\Core\Api\Concerns\InteractsWithMidtransApi;
use Bensondevs\Midtrans\Core\Endpoint;

class FetchPromotion
{
    use InteractsWithMidtransApi;

    public function __construct(
        protected string $accountId,
        protected string $grossAmount,
        protected ?string $currency = 'IDR',
    ) {}

    public static function make(
        string $accountId,
        string $grossAmount,
        string $currency = 'IDR',
    ): static {
        return new self(
            $accountId,
            $grossAmount,
            $currency,
        );
    }

    protected function getApiEndpoint(): string
    {
        return Endpoint::fetchPromotion($this->accountId);
    }

    protected function getPayloadData(): array
    {
        return [
            'gross_amount' => $this->grossAmount,
            'currency' => $this->currency,
        ];
    }

    public function getRecommendedPromotionId(): ?string
    {
        return $this->getResponseAttribute('recommended_promotion_id', '');
    }

    public function getPromotions(): ?array
    {
        return $this->getResponseAttribute('promotions', []);
    }
}
