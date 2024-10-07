<?php

declare(strict_types=1);

namespace Viking311\Queue\Application\UseCase\ProcessEvent;

use Viking311\Queue\Application\Adapter\QueueAdapterInterface;

class ProcessEventUseCase
{
    public function __construct(
        private QueueAdapterInterface $queue
    ) {

    }

    public function __invoke(): ProcessEventResponse
    {
        $msg = $this->queue->receive();
        var_dump($msg);
        return new ProcessEventResponse($msg);
    }

}
