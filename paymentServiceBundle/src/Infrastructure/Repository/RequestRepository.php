<?php

namespace PaymentServiceBundle\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestStatusEnum;
use PaymentServiceBundle\Domain\Entity\Request;
use PaymentServiceBundle\Domain\Repository\RequestRepositoryInterface;

class RequestRepository implements RequestRepositoryInterface
{
    public function __construct(protected readonly EntityManagerInterface $entityManager)
    {
    }

    public function createRequest(Request $request): Request
    {
        $this->entityManager->persist($request);
        $this->entityManager->flush();

        return $request;
    }

    public function setRequestStatus(Request $request, RequestStatusEnum $requestStatus): void
    {
        $request->setStatus($requestStatus);
        $this->entityManager->flush();
    }

    public function getRequestByUuid(string $uuid): ?Request
    {
        return $this->entityManager->getRepository(Request::class)->findOneBy(['uuid' => $uuid]);
    }
}
