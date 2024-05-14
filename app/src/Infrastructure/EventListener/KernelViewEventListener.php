<?php

declare(strict_types=1);

namespace App\Infrastructure\EventListener;

use App\Application\Service\UseCaseResponseInterface;
use App\Infrastructure\Http\Response\SuccessResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class KernelViewEventListener
{
    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    public function onKernelView(ViewEvent $event): void
    {
        $value = $event->getControllerResult();

        if (!$value instanceof UseCaseResponseInterface) {
            return;
        }

        $event->setResponse($this->getHttpResponse(new SuccessResponse($value->getData())));
    }

    private function getHttpResponse(SuccessResponse $successResponse): Response
    {
        $responseData = $this->serializer->serialize(
            $successResponse,
            JsonEncoder::FORMAT,
            [ AbstractObjectNormalizer::SKIP_NULL_VALUES => true ]
        );

        return new Response($responseData, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
