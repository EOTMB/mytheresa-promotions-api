<?php

declare(strict_types=1);

namespace App\Infrastructure\Listener;

use App\Domain\Exception\Product\ProductAlreadyExistException;
use App\Domain\Exception\Product\ProductsNotFoundException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class JsonExceptionResponseTransformerListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $exceptionClass = \get_class($exception);

        $data = [
            'class' => $exceptionClass,
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ];

        if (in_array($exceptionClass, $this->getBadRequestExceptions(), true)) {
            $data['code'] = JsonResponse::HTTP_BAD_REQUEST;
        }

        if (in_array($exceptionClass, $this->getConflictExceptions(), true)) {
            $data['code'] = JsonResponse::HTTP_CONFLICT;
        }

        if (in_array($exceptionClass, $this->getNotFoundExceptions(), true)) {
            $data['code'] = JsonResponse::HTTP_NOT_FOUND;
        }

        if ($exception instanceof AccessDeniedException) {
            $data['code'] = JsonResponse::HTTP_FORBIDDEN;
        }

        $event->setResponse($this->prepareResponse($data));
    }

    private function prepareResponse(array $data): JsonResponse
    {
        $code = $data['code'] ?? JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
        $response = new JsonResponse($data, $code);
        $response->headers->set('Server-Time', \time());
        $response->headers->set('X-Error-Code', $code);

        return $response;
    }

    private function getBadRequestExceptions(): array
    {
        return [BadRequestException::class, ProductAlreadyExistException::class];
    }

    private function getConflictExceptions(): array
    {
        return [ConflictHttpException::class];
    }

    private function getNotFoundExceptions(): array
    {
        return [NotFoundHttpException::class, ProductsNotFoundException::class];
    }
}
