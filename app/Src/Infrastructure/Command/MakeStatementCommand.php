<?php

namespace Src\Infrastructure\Command;


use Src\Application\UseCase\MakeStatement\MakeStatementRequest;
use Src\Application\UseCase\MakeStatement\MakeStatementUseCase;
use Src\Application\UseCase\MakeStatement\MakeStatementResponse;

class MakeStatementCommand
{
    private MakeStatementUseCase $useCase;
    public function __construct(MakeStatementUseCase $useCase)
    {
        $this->useCase = $useCase;
    }
    public function __invoke(MakeStatementRequest $request): MakeStatementResponse
    {
        return ($this->useCase)($request);
    }
}
