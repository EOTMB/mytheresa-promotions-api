<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Service\DiscountCalculator;
use App\Domain\ValueObject\IntegerValueObject;
use App\Domain\ValueObject\ProductCategory;
use App\Domain\ValueObject\ProductDiscount;
use App\Domain\ValueObject\ProductName;
use App\Domain\ValueObject\ProductPrice;
use App\Domain\ValueObject\ProductSku;
use App\Domain\ValueObject\UuidValueObject;
use Symfony\Component\Uid\Uuid;

final class Product
{
    private UuidValueObject $id;

    private ProductSku $sku;

    private ProductName $name;

    private ProductCategory $category;

    private ProductPrice $price;

    private ?ProductDiscount $discount = null;

    private function __construct(UuidValueObject $id, ProductSku $sku, ProductName $name, ProductCategory $category, ProductPrice $price)
    {
        $this->id = $id;
        $this->sku = $sku;
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
    }

    public static function createFromPrimitives(
        string $sku,
        string $name,
        string $category,
        int $price
    )
    {
        $id = new UuidValueObject(Uuid::v4()->toRfc4122());
        $sku = new ProductSku($sku);
        $name = new ProductName($name);
        $category = new ProductCategory($category);
        $price = new ProductPrice($price);

        return new static($id, $sku, $name, $category, $price);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'sku' => $this->getSku(),
            'name' => $this->getName(),
            'category' => $this->getCategory(),
            'price' => $this->getPrice(),
        ];
    }

    public function setId(UuidValueObject $id): void
    {
        $this->id = $id;
    }

    public function setDiscount(?ProductDiscount $discount): void
    {
        $this->discount = $discount;
    }

    public function getId(): ?UuidValueObject
    {
        return $this->id;
    }

    public function getSku(): ProductSku
    {
        return $this->sku;
    }

    public function getName(): ProductName
    {
        return $this->name;
    }

    public function getCategory(): ProductCategory
    {
        return $this->category;
    }

    public function getPrice(): ProductPrice
    {
        return $this->price;
    }

    public function getPriceWithDiscount()
    {
        return $this->price->toArrayWithDiscount($this->discount?->value());
    }
}
