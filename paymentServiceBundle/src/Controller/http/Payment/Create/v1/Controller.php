<?php

namespace PaymentServiceBundle\Controller\http\Payment\Create\v1;

use PaymentServiceBundle\Controller\BundleUrlPrefixEnum\BundleUrlPrefixEnum;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    private const SITE_URL_PREFIX = BundleUrlPrefixEnum::PaymentService->value;

    public function __construct(
        private readonly Handler $handler,
    ) {
    }

    #[Route(path: self::SITE_URL_PREFIX . '/api/v1/payment', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] RequestDTO $requestDTO): Response
    {
        return new JsonResponse(['requestId' => $this->handler->create($requestDTO)]);
    }
}

