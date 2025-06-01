<?php

namespace Bensondevs\Midtrans\Models\Concerns;

use Illuminate\Database\Eloquent\Model;

/**
 * @TODO
 *
 * @mixin \Bensondevs\Midtrans\Contracts\Subscribable
 */
class InteractsWithMidtransSubscription
{
    public function getMaxInterval(): ?int
    {
        if (method_exists($this, 'maxInterval')) {
            return (int) $this->maxInterval();
        }

        if (! $this instanceof Model) {
            return null;
        }

        if (filled($this->max_interval)) {
            return intval($this->max_interval);
        }

        return null;
    }

    public function getStartTime(): ?string
    {
        return now()->toDateTimeString();
    }

    public function hasRetrySchedule(): bool
    {
        $key = 'midtrans.subscriptions.has_retry_schedule';

        return (bool) config($key, true);
    }

    public function getRetryScheduleInterval(): int
    {
        $key = 'midtrans.subscriptions.retry_schedule.interval';

        return (int) config($key, 1);
    }

    public function getRetryScheduleIntervalUnit(): string
    {
        $key = 'midtrans.subscriptions.retry_schedule.interval_unit';

        return (string) config($key, 'day');
    }

    public function getRetryScheduleMaxInterval(): int
    {
        $key = 'midtrans.subscriptions.retry_schedule.max_interval';

        return (int) config($key, 3);
    }

    public function getMetadata(): array
    {
        if (! $this instanceof Model) {
            return $this->metadata ?? [];
        }

        if (is_array($this->metadata)) {
            return $this->metadata;
        }

        if (is_string($this->metadata)) {
            $decoded = json_decode($this->metadata, true);

            return is_array($decoded) ? $decoded : [$this->metadata];
        }

        return [];
    }
}
