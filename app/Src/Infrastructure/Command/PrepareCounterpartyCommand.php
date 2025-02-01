<?php

namespace Src\Infrastructure\Command;

use Src\Application\UseCase\PrepareCounterparty\PrepareCounterpartyRequest;
use Src\Application\UseCase\PrepareCounterparty\PrepareCounterpartyUseCase;

class PrepareCounterpartyCommand
{
    private PrepareCounterpartyUseCase $useCase;
    public function __construct(PrepareCounterpartyUseCase $useCase)
    {
        $this->useCase = $useCase;
    }
    public function __invoke(PrepareCounterpartyRequest $request)
    {
        $response = ($this->useCase)($request);
        return $response;
    }
}
