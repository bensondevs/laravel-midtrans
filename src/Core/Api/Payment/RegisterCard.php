<?php

namespace Bensondevs\Midtrans\Core\Api\Payment;

use Bensondevs\Midtrans\Core\Api\Concerns\InteractsWithMidtransApi;
use Bensondevs\Midtrans\Core\Authentication;
use Bensondevs\Midtrans\Core\Endpoint;

class RegisterCard
{
    use InteractsWithMidtransApi;

    public function __construct(
        protected string $cardNumber,
        protected string $cardExpirationMonth,
        protected string $cardExpirationYear,
        protected string $callback = '',
    ) {}

    public static function make(
        string $cardNumber,
        string $cardExpirationMonth,
        string $cardExpirationYear,
    ): static {
        $registerCard = new static(
            $cardNumber,
            $cardExpirationMonth,
            $cardExpirationYear,
        );

        $registerCard->get();

        return $registerCard;
    }

    protected function getApiEndpoint(): string
    {
        return Endpoint::registerCard();
    }

    protected function getPayloadData(): array
    {
        return array_filter([
            'card_number' => $this->cardNumber,
            'card_exp_month' => $this->cardExpirationMonth,
            'card_exp_year' => $this->cardExpirationYear,
            'client_key' => Authentication::clientKey(),
            'callback' => $this->callback,
        ], fn (mixed $value) => filled($value));
    }

    public function getSavedTokenId(): ?string
    {
        return $this->getResponseAttribute('saved_token_id', '');
    }

    public function getTransactionId(): ?string
    {
        return $this->getResponseAttribute('transaction_id', '');
    }

    public function getMaskedCard()
    {
        return $this->getResponseAttribute('masked_card', '');
    }
}
