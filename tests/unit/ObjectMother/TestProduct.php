<?php

namespace App\Tests\unit\ObjectMother;

use App\Domain\Enum\CategoryEnum;
use App\Domain\Enum\SkuEnum;
use App\Domain\Product;

class TestProduct
{
    public static function aBootsProduct(): Product
    {
        return Product::createFromPrimitives(
             "000002",
			"BV Lean leather ankle boots",
			CategoryEnum::BOOTS_CATEGORY,
			 99000
        );
    }

    public static function aBootsProductWithSpecialDiscountSKU(): Product
    {
        return Product::createFromPrimitives(
            SkuEnum::SKU_PRODUCT_SPECIAL,
            "BV Lean leather ankle boots",
            CategoryEnum::BOOTS_CATEGORY,
            99000
        );
    }

    public static function aProductWithSpecialDiscountSKU(): Product
    {
        return Product::createFromPrimitives(
            SkuEnum::SKU_PRODUCT_SPECIAL,
            "BV Lean leather ankle boots",
            "sneakers",
            99000
        );
    }

    public static function aSneakerProduct(): Product
    {
        return Product::createFromPrimitives(
            "000005",
			 "Nathane leather sneakers",
			 CategoryEnum::SNEAKERS_CATEGORY,
			 59000
        );
    }

}