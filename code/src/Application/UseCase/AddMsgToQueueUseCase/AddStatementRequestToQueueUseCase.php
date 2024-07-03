<?php

namespace App\Application\UseCase\AddStatementRequestToQueueUseCase;

use App\Application\Interface\QueueAddMsgInterface;
use App\Domain\Entity\StatementRequest;

class AddStatementRequestToQueueUseCase
{

    private StatementRequest $statementRequest;
    private QueueAddMsgInterface $queue;

    public function __construct(
        StatementRequest $statementRequest,
        QueueAddMsgInterface $queue
    ) {
        $this->statementRequest = $statementRequest;
        $this->queue = $queue;
    }

    public function __invoke(): string
    {
        try {
            $this->queue->add($this->statementRequest->getStatementRequest());
        } catch (\InvalidArgumentException) {
            throw new \InvalidArgumentException("Adding statement request failed");
        }
        return "Statement request added successfully";
    }

}