<?php

declare(strict_types=1);

namespace App\Infrastructure\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class KernelViewEventListener
{
    public function onKernelView(ViewEvent $event): void
    {
        $event->setResponse($this->getHttpResponse($event->getControllerResult()));
    }

    private function getHttpResponse(mixed $value): Response
    {
        return new JsonResponse($value);
    }
}
