<?php

declare(strict_types=1);

namespace App\Application\Product\DTO;

final class ProductsResponse
{
    private array $products;

    public function __construct(ProductResponse ...$products)
    {
        $this->products = $products;
    }

    public function getProducts(): array
    {
        return $this->products;
    }
}
