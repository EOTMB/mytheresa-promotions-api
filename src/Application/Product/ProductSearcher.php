<?php

declare(strict_types=1);

namespace App\Application\Product;

use App\Application\Discount\ClientDiscount;
use App\Application\Product\DTO\ProductResponse;
use App\Application\Product\DTO\ProductSearcherRequest;
use App\Application\Product\DTO\ProductsResponse;
use App\Domain\Criteria\Criteria;
use App\Domain\Criteria\FilterOperator;
use App\Domain\Criteria\Filters;
use App\Domain\Criteria\Order;
use App\Domain\Exception\Product\ProductsNotFoundException;
use App\Domain\Product;
use App\Domain\Service\DiscountCalculator;
use App\Domain\ValueObject\ProductCategory;
use App\Domain\ValueObject\ProductPrice;
use App\Infrastructure\Repository\ProductRepository;

use function Lambdish\Phunctional\map;

class ProductSearcher
{
    private ProductRepository $productRepository;
    private DiscountCalculator $discountCalculator;

    public function __construct(DiscountCalculator $discountCalculator, ProductRepository $productRepository)
    {
        $this->discountCalculator = $discountCalculator;
        $this->productRepository = $productRepository;
    }

    public function __invoke(ProductSearcherRequest $productsSearcherRequest): ProductsResponse
    {
        $category = $productsSearcherRequest->category() ? new ProductCategory($productsSearcherRequest->category()) : null;
        $priceLessThan = $productsSearcherRequest->priceLessThan() ? new ProductPrice($productsSearcherRequest->priceLessThan()) : null;


        $products = $this->productRepository->search($category, $priceLessThan);
        if (!$products)
        {
            if (!is_null($productsSearcherRequest->category()))
            {
                
            }
            throw ProductsNotFoundException::fromCategory((string)$category);
        }

        foreach ($products as $product) {
            $discount = $this->discountCalculator->calculateDiscounts($product);
            $product->setDiscount($discount);
        }

        return new ProductsResponse(...map($this->toResponse(), $products));
    }

    private function toResponse(): callable
    {
        return static fn (Product $product) => new ProductResponse(
            (string)$product->getId(),
            (string)$product->getSku(),
            (string)$product->getName(),
            (string)$product->getCategory(),
            $product->getPriceWithDiscount()
        );
    }
}
