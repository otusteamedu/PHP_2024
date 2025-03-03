<?php

namespace App\Application\UseCase\GetStatementUseCase;

use App\Domain\Repository\RequestRepositoryInterface;
use App\Domain\Repository\StatementRepositoryInterface;
use App\Domain\Repository\TransactionRepositoryInterface;
use App\Domain\ValueObject\Status;
use App\Infrastructure\Entity\StatusEnum;
use Exception;

class GetRequestUseCase
{
    public function __construct(
        private readonly RequestRepositoryInterface $requestRepository
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(GetRequestRequest $request): GetRequestResponse
    {
        $request = $this->requestRepository->findById($request->requestId);
        if(!$request){
            throw new Exception('Request not found');
        }
        return new GetRequestResponse(
            $request->getStatus()->getValue()
        );
    }
}
