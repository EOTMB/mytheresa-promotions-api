<?php

declare(strict_types=1);

namespace App\Infrastructure\ProductFixtures;

use App\Domain\Enum\CategoryEnum;
use App\Domain\Product;
use App\Domain\ValueObject\UuidValueObject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Symfony\Component\Uid\Uuid;

final class  ProductFixtures extends Fixture
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        /*
        $json = <<<'JSON'
{
	"products": [
		{
			"sku": "000001",
			"name": "BV Lean leather ankle boots",
			"category": "boots",
			"price": 89000
		},
		{
			"sku": "000002",
			"name": "BV Lean leather ankle boots",
			"category": "boots",
			"price": 99000
		},
		{
			"sku": "000003",
			"name": "Ashlington leather ankle boots",
			"category": "boots",
			"price": 71000
		},
		{
			"sku": "000004",
			"name": "Naima embellished suede sandals",
			"category": "sandals",
			"price": 79500
		},
		{
			"sku": "000005",
			"name": "Nathane leather sneakers",
			"category": "sneakers",
			"price": 59000
		}
	]
}
JSON;
        $jsonProducts = json_decode($json, true)['products'];
        foreach ($jsonProducts as $jsonProduct) {
            extract($jsonProduct);
            $product =  Product::createFromPrimitives(
                $sku,
                $name,
                $category,
                $price
            );
            $product->setId(new UuidValueObject(Uuid::v4()->toRfc4122()));
            $manager->persist($product);
        */

        for ($i = 0; $i < 500; ++$i) {
            $product = Product::createFromPrimitives(
                '00000'.$i,
                'product '.$i,
                CategoryEnum::AVAILABLE_CATEGORIES[array_rand(CategoryEnum::AVAILABLE_CATEGORIES)],
                random_int(10000, 99999)
            );
            $product->setId(Uuid::v4()->toRfc4122());
            $manager->persist($product);
        }

        $manager->flush();
    }
}
