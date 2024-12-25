<?php

namespace PaymentServiceBundle\Controller\http\Payment\Delete\v1;

use PaymentServiceBundle\Controller\BundleUrlPrefixEnum\BundleUrlPrefixEnum;
use PaymentServiceBundle\Domain\Entity\Request;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    private const SITE_URL_PREFIX = BundleUrlPrefixEnum::PaymentService->value;

    public function __construct(private readonly Handler $handler) {
    }

    #[Route(path: self::SITE_URL_PREFIX . '/api/v1/payment/{uuid}', methods: ['DELETE'])]
    public function __invoke(#[MapEntity(id: 'uuid')] ?Request $request): Response
    {
        $result = $this->handler->delete($request);

        return new JsonResponse(['requestId' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }
}
