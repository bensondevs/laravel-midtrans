<?php

namespace Bensondevs\Midtrans\Models\Concerns\Billable;

use Bensondevs\Midtrans\Core\Api\Payment\RegisterCard;
use Bensondevs\Midtrans\Models\RegisteredCard;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasRegisteredCards
{
    public function registeredCards(): MorphMany
    {
        return $this->morphMany(RegisteredCard::class, 'holder');
    }

    public function registerCard(
        string $cardNumber,
        string $cardExpirationMonth,
        string $cardExpirationYear,
    ): ?RegisteredCard {
        $registerCard = RegisterCard::make(
            $cardNumber,
            $cardExpirationMonth,
            $cardExpirationYear,
        );
        $response = $registerCard->get();

        $tokenId = $response['saved_token_id'] ?? '';

        if (blank($tokenId)) {
            return null;
        }

        $card = new RegisteredCard;
        $card->holder()->associate($this);
        $card->token_id = $tokenId;
        $card->masked_card = $response['masked_card'] ?? '';
        $card->status = $response['status'] ?? '';
        $card->is_main = $this->registeredCards()
            ->where('is_main', true)
            ->doesntExist();
        $card->save();

        return $card;
    }
}
