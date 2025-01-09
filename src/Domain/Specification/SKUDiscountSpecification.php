<?php

namespace App\Domain\Specification;

use App\Domain\Enum\SkuEnum;
use App\Domain\Product;

class SKUDiscountSpecification extends ProductDiscountSpecification
{
    public const DISCOUNT_VALUE = 15;
    public function isSatisfiedBy(Product $product): bool
    {
        return SkuEnum::SKU_PRODUCT_SPECIAL === $product->getSku()->value();
    }
}