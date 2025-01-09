<?php

namespace App\Domain\ValueObject;

class ProductPrice extends IntegerValueObject
{
    public const CURRENCY_EUR = 'EUR';

    public function toArrayWithDiscount(?int $discountPercentage): array
    {
        return [
            'original' => $this->value(),
            'final' => $this->priceWithDiscount($discountPercentage),
            'discount_percentage' => !is_null($discountPercentage) ? $discountPercentage.'%' : null,
            'currency' => $this->getCurrency()
        ];

    }

    public function setId(UuidValueObject $id): void
    {
        $this->id = $id;
    }

    public function getCurrency(): string
    {
        return self::CURRENCY_EUR;
    }

    public function priceWithDiscount(?int $discountPercentage): int
    {
        return (int) round($this->value() * ((100 - ($discountPercentage ?? 0)) / 100), 2);
    }

}