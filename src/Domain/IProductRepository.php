<?php

namespace App\Domain;

use App\Domain\ValueObject\ProductCategory;
use App\Domain\ValueObject\ProductPrice;

interface IProductRepository
{
    public function search(?ProductCategory $category, ?ProductPrice $priceLesserThan);
}
