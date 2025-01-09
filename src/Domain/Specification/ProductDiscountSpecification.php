<?php

namespace App\Domain\Specification;

use App\Domain\Product;

abstract class ProductDiscountSpecification
{
    abstract public function isSatisfiedBy(Product $product): bool;
    public function getDiscount()
    {
        return static::DISCOUNT_VALUE;
    }
}