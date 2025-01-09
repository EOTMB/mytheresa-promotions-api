<?php

declare(strict_types=1);

namespace App\Domain\Enum;

final class DiscountEnum
{
    public const BOOTS_CATEGORY_DISCOUNT = 30;
    public const SKU_PRODUCT_DISCOUNT = 15;

    public const AVAILABLE_DISCOUNTS = [
        self::BOOTS_CATEGORY_DISCOUNT,
        self::SKU_PRODUCT_DISCOUNT,
    ];
}
