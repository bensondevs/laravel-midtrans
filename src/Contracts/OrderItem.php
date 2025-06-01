<?php

namespace Bensondevs\Midtrans\Contracts;

interface OrderItem
{
    public function getId(): ?string;

    public function getPrice(): int;

    public function getQuantity(): int;

    public function getName(): string;

    public function getBrand(): ?string;

    public function getCategory(): ?string;

    public function getMerchantName(): ?string;

    public function getUrl(): ?string;
}
