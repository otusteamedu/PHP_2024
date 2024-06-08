<?php

declare(strict_types=1);

namespace App\Infrastructure\EventListener;

use App\Domain\Exception\EntityNotFoundException;
use App\Infrastructure\Http\Response\ErrorResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class KernelExceptionEventListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = match (true) {
            $exception instanceof \InvalidArgumentException, $exception instanceof HttpException && $exception->getPrevious() instanceof ValidationFailedException => $this->getHttpResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST),
            $exception instanceof EntityNotFoundException => $this->getHttpResponse($exception->getMessage(), Response::HTTP_NOT_FOUND),
            default => $this->getHttpResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR),
        };

        $event->setResponse($response);
    }

    private function getHttpResponse(string $message, int $code): Response
    {
        $responseData = [
            'message' => $message,
            'code' => $code,
            'error' => Response::$statusTexts[$code],
            'timestamp' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
        ];

        return new JsonResponse($responseData, $code);
    }
}
