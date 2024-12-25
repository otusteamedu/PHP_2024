<?php

namespace PaymentServiceBundle\Domain\Repository;

use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestStatusEnum;
use PaymentServiceBundle\Domain\Entity\Request;

interface RequestRepositoryInterface
{
    public function createRequest(Request $request): Request;

    public function setRequestStatus(Request $request, RequestStatusEnum $requestStatus): void;

    public function getRequestByUuid(string $uuid): ?Request;
}
