<?php

namespace PaymentServiceBundle\Controller\http\Payment\Get\v2;

use PaymentServiceBundle\Controller\BundleUrlPrefixEnum\BundleUrlPrefixEnum;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class Controller
{
    private const SITE_URL_PREFIX = BundleUrlPrefixEnum::PaymentService->value;

    public function __construct(
        private readonly Handler $handler,
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Route(path: self::SITE_URL_PREFIX . '/api/v2/payment/{uuid}', methods: ['GET'])]
    public function __invoke($uuid): Response
    {
        $result = $this->handler->get($uuid);

        return new JsonResponse(
            $this->serializer->serialize(
                $result->paymentDTO ?? $result->message,
                JsonEncoder::FORMAT
            ), Response::HTTP_OK, [], true
        );
    }
}
