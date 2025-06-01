<?php

namespace Bensondevs\Midtrans\Http\Controllers\Webhook;

use Bensondevs\Midtrans\Http\Requests\MidtransRequest;

class EventBasedNotificationHandlerController
{
    public function __invoke(MidtransRequest $request): void
    {
        $payload = $request->getMidtransPayload();

        // Update the payment methods

        // Handle the transactions

        //
    }
}
