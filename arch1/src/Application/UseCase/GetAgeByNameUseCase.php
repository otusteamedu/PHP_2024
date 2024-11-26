<?php

namespace App\Application\UseCase;

use App\Application\Contracts\DTO\GetNameInterface;
use App\Domain\Entity\NameAge;
use App\Domain\Factory\NameAgeFactory;
use App\Domain\Gateway\RequestAgeByNameGatewayInterface;
use App\Domain\Repository\NameAgeRepositoryInterface;

class GetAgeByNameUseCase
{
    public function __construct(
        private NameAgeFactory $nameAgeFactory,
        private RequestAgeByNameGatewayInterface $requestAgeByNameGateway,
        private NameAgeRepositoryInterface $nameAgeRepository
    ){}

    public function __invoke(GetNameInterface $args): NameAge
    {
        $nameAge = $this->nameAgeRepository->find($args->getName());

        if (empty($nameAge)) {
            $age = $this->requestAgeByNameGateway->requestAge($args->getName());

            $nameAge = $this->nameAgeFactory->create($args->getName(), $age);

            $this->nameAgeRepository->save($nameAge);
        }

        return $nameAge;
    }
}