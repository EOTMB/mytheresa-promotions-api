<?php

namespace App\Infrastructure\Controller;

use App\Application\Product\DTO\ProductSearcherRequest;
use App\Application\Product\ProductSearcher;
use Symfony\Component\BrowserKit\Exception\JsonException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;

final class GetProducts extends AbstractController
{
    public function __invoke(
        Request $request,
        ProductSearcher $searcher
    ): JsonResponse
    {
        $queryStringData = $request->query->all();

        $this->ensureRequestIsValid($queryStringData, $this->constraints());
        $category = $queryStringData['category'] ?? null;
        $priceLessThan = $queryStringData['priceLessThan'] ?? null;

        $productsSearcherRequest = new ProductSearcherRequest(
            $category,
            $priceLessThan
        );

        $products = $searcher($productsSearcherRequest);



        return $this->json($products);
    }

    private function constraints():array
    {
        return [
            'category' => [new Assert\Optional(new Assert\Type('string'))],
            'priceLessThan' => [new Assert\Optional(new Assert\Type('numeric'))],
        ];

    }

    public function ensureRequestIsValid(?array $input, array $constraints): void
    {
        if (is_null($input)) {
            throw new JsonException();
        }
        $validator = Validation::createValidator();
        $constraint = new Assert\Collection($constraints);
        $violations = $validator->validate($input, $constraint);
        if (count($violations) > 0) {
            throw new \InvalidArgumentException(
                <<<MESSAGE
{$violations[0]->getPropertyPath()}: {$violations[0]->getMessage()} {$violations[0]->getInvalidValue()}
MESSAGE

            );
        }
    }
}