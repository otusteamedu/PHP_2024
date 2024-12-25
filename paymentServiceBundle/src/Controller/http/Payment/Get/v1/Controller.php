<?php

namespace PaymentServiceBundle\Controller\http\Payment\Get\v1;

use PaymentServiceBundle\Controller\BundleUrlPrefixEnum\BundleUrlPrefixEnum;
use PaymentServiceBundle\Domain\Entity\Request;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
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

    #[Route(path: self::SITE_URL_PREFIX . '/api/v1/payment/{uuid}', methods: ['GET'])]
    public function __invoke(#[MapEntity(id: 'uuid')] ?Request $request): Response
    {
        $result = $this->handler->get($request);

        if ($result) {
            return new JsonResponse(
                $this->serializer->serialize(
                    $result,
                    JsonEncoder::FORMAT
                ), Response::HTTP_OK, [], true
            );
        }

        return new JsonResponse(['message' => $result], Response::HTTP_NOT_FOUND);
    }
}
