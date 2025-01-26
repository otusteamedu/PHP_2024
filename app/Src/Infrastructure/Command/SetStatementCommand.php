<?php

namespace Src\Infrastructure\Command;


use Src\Application\UseCase\SetStatement\SetStatementRequest;
use Src\Application\UseCase\SetStatement\SetStatementUseCase;
use Src\Application\UseCase\SetStatement\SetStatementResponse;

class SetStatementCommand
{
    private SetStatementUseCase $useCase;
    public function __construct(SetStatementUseCase $useCase)
    {
        $this->useCase = $useCase;
    }
    public function __invoke(SetStatementRequest $request): SetStatementResponse
    {
        return ($this->useCase)($request);
    }
}
