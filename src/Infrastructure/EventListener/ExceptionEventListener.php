<?php

namespace App\Infrastructure\EventListener;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class ExceptionEventListener
{
    private const DEFAULT_PROPERTY = 'error';

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof HttpExceptionInterface) {
            $exception = $exception->getPrevious();
        }
        if ($exception instanceof ConnectException || $exception instanceof ClientException) {
            $event->setResponse($this->getHttpResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST));
        }
        if ($exception instanceof ValidationFailedException) {
            $event->setResponse($this->getValidationFailedResponse($exception));
        }
    }

    private function getHttpResponse($message, $code): Response
    {
        return new JsonResponse([self::DEFAULT_PROPERTY => $message], $code);
    }

    private function getValidationFailedResponse(ValidationFailedException|UniqueConstraintViolationException|ConnectException $exception): Response
    {
        $response = [];
        if ($exception instanceof ValidationFailedException) {
            foreach ($exception->getViolations() as $violation) {
                $property = empty($violation->getPropertyPath()) ? self::DEFAULT_PROPERTY : $violation->getPropertyPath();
                $response[$property] = $violation->getMessage();
            }
        }

        return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
    }
}
