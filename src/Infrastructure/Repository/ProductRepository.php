<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\IProductRepository;
use App\Domain\Product;
use App\Domain\ValueObject\ProductCategory;
use App\Domain\ValueObject\ProductPrice;

class ProductRepository extends BaseRepository implements IProductRepository
{
    protected static function entityClass(): string
    {
        return Product::class;
    }

    public function search(?ProductCategory $category, ?ProductPrice $priceLesserThan)
    {
        $qb = $this->createQueryBuilder()->select('p')
        ->from(Product::class, 'p');

        if (!is_null($category)) {
            $qb->andWhere('p.category.value = :category');
            $qb->setParameter('category', (string)$category);
        }
        if (!is_null($priceLesserThan)) {
            $qb->andWhere('p.price.value < :priceLesserThan');
            $qb->setParameter('priceLesserThan', $priceLesserThan->value());
        }

        $qb->setMaxResults(5);

        $query = $qb->getQuery();
        return $query->getResult();

    }
}
