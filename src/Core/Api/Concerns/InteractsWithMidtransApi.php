<?php

namespace Bensondevs\Midtrans\Core\Api\Concerns;

use Bensondevs\Midtrans\Core\Authentication;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

trait InteractsWithMidtransApi
{
    protected ?Response $response = null;

    abstract protected function getApiEndpoint(): string;

    abstract protected function getPayloadData(): array;

    public function send(): ?array
    {
        $headers = Authentication::apiHeaders();

        $endpoint = $this->getApiEndpoint();
        $payload = $this->getPayloadData();

        $response = Http::withHeaders($headers)->post($endpoint, $payload);

        $this->response = $response;

        return $response->json();
    }

    public function get(): ?array
    {
        $headers = Authentication::apiHeaders();

        $endpoint = $this->getApiEndpoint();
        $payload = $this->getPayloadData();

        $response = Http::withHeaders($headers)->get($endpoint, $payload);

        $this->response = $response;

        return $response->json();
    }

    public function getResponseStatus(): ?int
    {
        return $this->response?->status();
    }

    public function getResponseData(): ?array
    {
        return $this->response?->json();
    }

    public function getResponseAttribute(string $attribute, mixed $default = null): mixed
    {
        return $this->getResponseData()[$attribute] ?? $default;
    }
}
