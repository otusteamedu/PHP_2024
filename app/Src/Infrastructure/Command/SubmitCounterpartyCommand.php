<?php

namespace Src\Infrastructure\Command;

use Src\Application\UseCase\SubmitCounterparty\SubmitCounterpartyRequest;
use Src\Application\UseCase\SubmitCounterparty\SubmitCounterpartyUseCase;

class SubmitCounterpartyCommand
{
    private SubmitCounterpartyUseCase $useCase;
    public function __construct(SubmitCounterpartyUseCase $useCase)
    {
        $this->useCase = $useCase;
    }
    public function __invoke(SubmitCounterpartyRequest $request)
    {
        $response = ($this->useCase)($request);
        return $response;
    }
}
