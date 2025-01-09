<?php

declare(strict_types=1);

namespace App\Application\Product\DTO;

final class ProductSearcherRequest
{
    private ?string $category;
    private ?int $priceLessThan;


    public function __construct(
        ?string $category,
        ?int $priceLessThan,
    ) {
        $this->category = $category;
        $this->priceLessThan = $priceLessThan;
    }

    public function category(): ?string
    {
        return $this->category;
    }

    public function priceLessThan(): ?int
    {
        return $this->priceLessThan;
    }
}
