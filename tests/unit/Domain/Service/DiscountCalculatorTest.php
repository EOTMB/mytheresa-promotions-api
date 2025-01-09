<?php

namespace App\Tests\unit\Domain\Service;

use App\Domain\Enum\DiscountEnum;
use App\Domain\Service\DiscountCalculator;
use App\Tests\unit\ObjectMother\TestProduct;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DiscountCalculatorTest extends KernelTestCase
{
    private DiscountCalculator $discountCalculator;

    public function setUp(): void
    {

        self::bootKernel();
        $this->discountCalculator = self::getContainer()->get(DiscountCalculator::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        restore_exception_handler();
    }

    public function testItShouldApplyTheBiggerDiscountForMultipleCollidingDiscounts(): void
    {
        $product = TestProduct::aBootsProductWithSpecialDiscountSKU();
        $discountsApplied = $this->discountCalculator->calculateDiscounts($product);

        $this->assertSame(
            DiscountEnum::BOOTS_CATEGORY_DISCOUNT, $discountsApplied->value());
    }

    public function testItShouldApplyABootsCategoryDiscount(): void
    {
        $product = TestProduct::aBootsProduct();
        $discountsApplied = $this->discountCalculator->calculateDiscounts($product);

        $this->assertSame(
            DiscountEnum::BOOTS_CATEGORY_DISCOUNT, $discountsApplied->value());
    }

    public function testItShouldApplySkuDiscount(): void
    {
        $product = TestProduct::aProductWithSpecialDiscountSKU();
        $discountsApplied = $this->discountCalculator->calculateDiscounts($product);

        $this->assertSame(
            DiscountEnum::SKU_PRODUCT_DISCOUNT, $discountsApplied->value());
    }

    public function testItShouldNotApplyAnyDiscount(): void
    {
        $product = TestProduct::aSneakerProduct();
        $discountsApplied = $this->discountCalculator->calculateDiscounts($product);

        $this->assertSame(
            null, $discountsApplied);
    }
}