<?php

namespace Bensondevs\Midtrans\Http\Requests;

use Bensondevs\Midtrans\Core\Authentication;
use Illuminate\Foundation\Http\FormRequest;

class MidtransRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->signatureIsVerified();
    }

    public function rules(): array
    {
        return [
            //
        ];
    }

    public function getMidtransPayload(): ?array
    {
        return json_decode($this->getContent(), associative: true) ?? $this->all();
    }

    protected function signatureIsVerified(): bool
    {
        $payload = $this->getMidtransPayload();

        return Authentication::verifyWebhookPayload($payload);
    }
}
