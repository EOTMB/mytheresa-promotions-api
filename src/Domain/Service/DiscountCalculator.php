<?php

namespace App\Domain\Service;

use App\Application\Discount\Discount;
use App\Domain\Product;
use App\Domain\ValueObject\ProductDiscount;

class DiscountCalculator
{
    private iterable $discountSpecifications;

    public function __construct(iterable $discountSpecifications)
    {
        $this->discountSpecifications = $discountSpecifications;
    }

    public function calculateDiscounts(Product $product): ?ProductDiscount
    {
        $highestDiscount = null;
        foreach ($this->discountSpecifications as $discountSpecification) {
            $discount = null;
            if ($discountSpecification->isSatisfiedBy($product)) {
                $discount = $discountSpecification->getDiscount($product);
            }
            if (($highestDiscount === null && $discount != null) || $discount > $highestDiscount) {
                $highestDiscount = $discount;
            }
        }
        return !is_null($highestDiscount) ? new ProductDiscount($highestDiscount) : null;
    }

}