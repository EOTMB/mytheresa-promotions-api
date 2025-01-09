<?php

declare(strict_types=1);

namespace App\Application\Product\DTO;

final class ProductResponse
{
    private string $id;
    private string $sku;
    private string $name;
    private string $category;
    private array $price;

    public function __construct(string $id, string $sku, string $name, string $category, array $price)
    {
        $this->id = $id;
        $this->sku = $sku;
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getPrice(): array
    {
        return $this->price;
    }
}
