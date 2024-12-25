<?php

namespace PaymentServiceBundle\Controller\http\Report\GetReport\v1;

use PaymentServiceBundle\Controller\BundleUrlPrefixEnum\BundleUrlPrefixEnum;
use PaymentServiceBundle\Domain\Entity\Report;
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
    private const CONTROLLER_URL_PREFIX = BundleUrlPrefixEnum::LinkForShowReport->value;

    public function __construct(
        private readonly Handler $handler,
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Route(path: self::SITE_URL_PREFIX . self::CONTROLLER_URL_PREFIX .'{uuid}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function __invoke(#[MapEntity(id: 'uuid')] ?Report $report): Response
    {
        $result = $this->handler->get($report);

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
