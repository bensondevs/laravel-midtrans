<?php

namespace Bensondevs\Midtrans\Enums\Concerns;

trait EnumExtensions
{
    public static function find(self|string|int|null $key): ?static
    {
        if ($key instanceof self) {
            return $key;
        }

        if (is_null($key)) {
            return null;
        }

        return self::tryFrom((string) $key);
    }

    public static function findOrDefault(self|string|int|null $key): static
    {
        return self::find($key) ?? self::default();
    }

    public static function default(): static
    {
        return self::cases()[0];
    }

    public static function getDefault(): static
    {
        return self::default();
    }

    public static function random(): static
    {
        $cases = self::cases();

        return collect($cases)->random();
    }

    public static function names(): array
    {
        return array_column(self::cases(), column_key: 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), column_key: 'value');
    }

    public static function asSelectOptions(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $enum): array => [
                $enum->value => match (true) {
                    method_exists($enum, method: 'getLabel') => $enum->getLabel(),
                    method_exists($enum, method: 'getName') => $enum->getName(),
                    default => $enum->name,
                },
            ])
            ->toArray();
    }

    public static function asSelectDescriptions(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $enum): array => [
                $enum->value => match (true) {
                    method_exists($enum, method: 'getDescription') => $enum->getDescription(),
                    method_exists($enum, method: 'getLabel') => $enum->getLabel(),
                    default => $enum->name,
                },
            ])
            ->toArray();
    }

    public function is(self|string|int|null $enum): bool
    {
        if (is_null($enum)) {
            return false;
        }

        if ($enum instanceof self) {
            return $this === $enum;
        }

        return $this === self::tryFrom($enum);
    }

    public function isIn(array $enums, bool $strict = false): bool
    {
        $normalizedEnums = collect($enums)
            ->map(fn (self|string|int $enum): self => self::find($enum))
            ->filter()
            ->toArray();

        return in_array($this, $normalizedEnums, strict: $strict);
    }

    public function isNot(self|string|int $enum): bool
    {
        return ! $this->is($enum);
    }

    public function isNotIn(array $enums, bool $strict = false): bool
    {
        return ! $this->isIn($enums, $strict);
    }

    public function getKey(): string|int
    {
        return $this->value;
    }

    public function getName(): string
    {
        return str($this->name)->headline()
            ->lower()->ucfirst()
            ->toString();
    }
}
