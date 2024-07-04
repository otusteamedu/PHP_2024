<?php

namespace App\Application\UseCase\AddStReqToQueueUseCase;

use App\Application\DTO\DTO;
use App\Application\Interface\QueueAddMsgInterface;
use App\Domain\Entity\StatementRequest;

class AddStReqToQueueUseCase
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
        $dto = new DTO($this->statementRequest->get());
        try {
            $this->queue->add($dto);
        } catch (\InvalidArgumentException) {
            throw new \InvalidArgumentException("Adding statement request failed");
        }
        return "Statement request added successfully";
    }

}