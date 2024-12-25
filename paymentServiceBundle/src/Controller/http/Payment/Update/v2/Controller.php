<?php

namespace PaymentServiceBundle\Controller\http\Payment\Update\v2;

use PaymentServiceBundle\Controller\BundleUrlPrefixEnum\BundleUrlPrefixEnum;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    private const SITE_URL_PREFIX = BundleUrlPrefixEnum::PaymentService->value;

    public function __construct(private readonly Handler $handler) {
    }

    #[Route(path: self::SITE_URL_PREFIX . '/api/v2/payment/{parentUuid}', methods: ['PATCH'])]
    public function __invoke(#[MapQueryString] RequestDTO $requestDTO, $parentUuid): Response
    {
        return new JsonResponse(['requestId' => $this->handler->update($requestDTO, $parentUuid)]);
    }
}

