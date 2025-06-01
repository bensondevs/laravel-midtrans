<?php

namespace Bensondevs\Midtrans\Contracts;

interface Subscribable
{
    public function getName(): string;

    public function getPrice(): int;

    public function getCurrency(): string;

    public function getInterval(): int;

    public function getIntervalUnit(): string;

    public function getMaxInterval(): ?int;

    public function getStartTime(): ?string;

    public function hasRetrySchedule(): bool;

    public function getRetryInterval(): int;

    public function getRetryIntervalUnit(): string;

    public function getRetryMaxInterval(): int;

    public function getMetadata(): array;
}
