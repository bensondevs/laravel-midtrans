<?php

namespace Bensondevs\Midtrans\Models\Concerns;

trait Subscribable
{
    public function getName(): string
    {
        return $this->guessValue([
            fn () => $this->name,
            fn () => $this->plan_name,
        ], '');
    }

    public function getPrice(): int
    {
        return $this->guessValue([
            fn () => $this->price,
            fn () => $this->amount,
        ], 0);
    }

    public function getCurrency(): string
    {
        return $this->guessValue([
            fn () => $this->currency,
        ], 'IDR');
    }

    public function getInterval(): int
    {
        return $this->guessValue([
            fn () => $this->interval,
        ], config('midtrans.subscription.retry_schedule.interval', 1));
    }

    public function getIntervalUnit(): string
    {
        return $this->guessValue([
            fn () => $this->interval_unit,
        ], config('midtrans.subscription.retry_schedule.interval_unit', 'day'));
    }

    public function getMaxInterval(): ?int
    {
        return $this->guessValue([
            fn () => $this->max_interval,
        ], config('midtrans.subscription.retry_schedule.max_interval'));
    }

    public function getStartTime(): ?string
    {
        return $this->guessValue([
            fn () => $this->start_time,
        ], null);
    }

    public function hasRetrySchedule(): bool
    {
        return $this->guessValue([
            fn () => $this->has_retry_schedule,
        ], config('midtrans.subscription.has_retry_schedule', true));
    }

    public function getRetryInterval(): int
    {
        return $this->guessValue([
            fn () => $this->retry_interval,
        ], config('midtrans.subscription.retry_schedule.interval', 1));
    }

    public function getRetryIntervalUnit(): string
    {
        return $this->guessValue([
            fn () => $this->retry_interval_unit,
        ], config('midtrans.subscription.retry_schedule.interval_unit', 'day'));
    }

    public function getRetryMaxInterval(): int
    {
        return $this->guessValue([
            fn () => $this->retry_max_interval,
        ], config('midtrans.subscription.retry_schedule.max_interval', 3));
    }

    public function getMetadata(): array
    {
        return $this->guessValue([
            fn () => $this->metadata,
        ], []);
    }

    protected function guessValue(array $callbacks, mixed $default = null): mixed
    {
        foreach ($callbacks as $callback) {
            try {
                if (is_callable($callback)) {
                    $value = $callback();

                    if (is_bool($value)) {
                        return $value;
                    }

                    if (is_string($value) && filled($value)) {
                        return $value;
                    }

                    if (is_numeric($value)) {
                        return $value;
                    }

                    if (is_array($value) && ! empty($value)) {
                        return $value;
                    }
                }
            } catch (\Throwable) {
                continue;
            }
        }

        return $default;
    }
}
