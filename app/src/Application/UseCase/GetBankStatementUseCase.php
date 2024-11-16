<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\SubmitStatementRequest;
use App\Application\UseCase\SubmitStatementResponse;
use App\Application\Services\QueueInterface;
use App\Domain\Entity\BankStatement;

class GetBankStatementUseCase
{
    public function __construct(private readonly QueueInterface $queue)
    {
    }

    public function __invoke(SubmitStatementRequest $request): SubmitStatementResponse
    {
        $this->queue->addMessage(new BankStatement($request->account, $request->dateFrom, $request->dateTo));
    }
}
