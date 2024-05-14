<?php

declare(strict_types=1);

namespace App\Infrastructure\EventListener;

use App\Domain\Exception\EntityNotFoundException;
use App\Domain\Exception\InvalidArgumentException;
use App\Infrastructure\Http\Response\ErrorResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class KernelExceptionEventListener
{
    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof InvalidArgumentException) {
            $event->setResponse($this->getHttpResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST));
        }

        if ($exception instanceof EntityNotFoundException) {
            $event->setResponse($this->getHttpResponse($exception->getMessage(), Response::HTTP_NOT_FOUND));
        }

        if ($exception instanceof HttpException && $exception->getPrevious() instanceof ValidationFailedException) {
            $event->setResponse($this->getHttpResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST));
        }

        $event->setResponse($this->getHttpResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR));
    }

    private function getHttpResponse($message, $code): Response
    {
        $message = new ErrorResponse($message);
        $responseData = $this->serializer->serialize($message, JsonEncoder::FORMAT);

        return new Response($responseData, $code, [ 'Content-Type' => 'application/json' ]);
    }
}
