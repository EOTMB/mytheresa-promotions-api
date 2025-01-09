<?php

namespace App\Tests\unit\Application;

use App\Application\Product\DTO\ProductSearcherRequest;
use App\Application\Product\ProductSearcher;
use App\Domain\Enum\CategoryEnum;
use App\Domain\Exception\Product\ProductsNotFoundException;
use App\Domain\Service\DiscountCalculator;
use App\Infrastructure\Repository\ProductRepository;
use App\Tests\unit\ObjectMother\TestProduct;
use PHPUnit\Framework\TestCase;

class ProductSearcherTest extends TestCase
{
    private $discountCalculator;
    private $productRepository;
    private $productSearcher;

    public function setUp(): void
    {
        $this->discountCalculator = $this->createMock(DiscountCalculator::class);
        $this->productRepository = $this->createMock(ProductRepository::class);
        $this->productSearcher = new ProductSearcher($this->discountCalculator, $this->productRepository);
    }

    public function testItReturnsProducts()
    {
        $productArray = $this->testProductArray();
        $this->givenIHaveAListOfProducts($productArray);
        $this->givenDiscountCalculatorReturnsDiscounts();
        $request = new ProductSearcherRequest(array_rand(CategoryEnum::AVAILABLE_CATEGORIES),null);

        $products = $this->productSearcher->__invoke($request);

        $index = 0;
        foreach ($productArray as $product) {

            $productResponse = $products->getProducts()[$index];
            $this->assertSame($productResponse->getId(), (string)$product->getId());
            $this->assertSame($productResponse->getSku(), (string)$product->getSku());
            $this->assertSame($productResponse->getName(), (string)$product->getName());
            $this->assertSame($productResponse->getCategory(), (string)$product->getCategory());
            $this->assertSame($productResponse->getPrice(), $product->getPriceWithDiscount());
            $index++;
        }
    }

    public function testItThrowsExceptionForEmptyProductsArray()
    {
        $this->givenIHaveAnEmptyListOfProducts();
        $this->givenDiscountCalculatorReturnsDiscounts();
        $this->expectException(ProductsNotFoundException::class);
        $request = new ProductSearcherRequest(array_rand(CategoryEnum::AVAILABLE_CATEGORIES),null);

        $products = $this->productSearcher->__invoke($request);
    }

    private function givenIHaveAListOfProducts($productArray)
    {
        $this->productRepository
            ->expects($this->any())
            ->method('search')
            ->willReturn($productArray);
    }

    private function givenIHaveAnEmptyListOfProducts()
    {
        $this->productRepository
            ->expects($this->any())
            ->method('search')
            ->willReturn([]);
    }

    private function givenDiscountCalculatorReturnsDiscounts()
    {
        $this->discountCalculator
            ->expects($this->any())
            ->method('calculateDiscounts')
            ->willReturn(null);
    }

    private function testProductArray()
    {
        return [
            TestProduct::aBootsProduct(),
            TestProduct::aSneakerProduct(),
            TestProduct::aProductWithSpecialDiscountSKU(),
        ];
    }

}