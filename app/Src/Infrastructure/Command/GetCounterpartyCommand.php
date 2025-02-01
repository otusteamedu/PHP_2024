<?php

namespace Src\Infrastructure\Command;

use Src\Application\UseCase\GetCounterparty\GetCounterpartyRequest;
use Src\Application\UseCase\GetCounterparty\GetCounterpartyUseCase;

class GetCounterpartyCommand
{
    private GetCounterpartyUseCase $useCase;
    public function __construct(GetCounterpartyUseCase $useCase)
    {
        $this->useCase = $useCase;
    }
    public function __invoke(GetCounterpartyRequest $request)
    {
        $response = ($this->useCase)($request);
        return $response;
    }
}
