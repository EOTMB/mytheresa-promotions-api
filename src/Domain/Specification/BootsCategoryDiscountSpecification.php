<?php

namespace App\Domain\Specification;

use App\Domain\Enum\CategoryEnum;
use App\Domain\Product;

class BootsCategoryDiscountSpecification extends ProductDiscountSpecification
{
    public const DISCOUNT_VALUE = 30;
    public function isSatisfiedBy(Product $product): bool
    {
        return CategoryEnum::BOOTS_CATEGORY === $product->getCategory()->value();
    }
}