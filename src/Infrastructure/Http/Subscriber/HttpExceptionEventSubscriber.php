<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class HttpExceptionEventSubscriber
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($exception instanceof HttpException) {
            $event->setResponse(
                new JsonResponse(
                    [
                        'error' => $exception->getMessage() ?: Response::$statusTexts[Response::HTTP_BAD_REQUEST],
                    ],
                    Response::HTTP_BAD_REQUEST
                )
            );
        }
    }
}