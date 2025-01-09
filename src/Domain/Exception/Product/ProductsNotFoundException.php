<?php

declare(strict_types=1);

namespace App\Domain\Exception\Product;

use DomainException;

class ProductsNotFoundException extends DomainException
{
    public static function fromCategory(string $category): self
    {
        throw new self(sprintf('No product found for category %s', $category));
    }
}
