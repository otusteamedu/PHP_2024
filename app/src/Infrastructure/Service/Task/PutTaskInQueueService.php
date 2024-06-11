<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Task;

use App\Infrastructure\Service\Queue\ProducerInterface;
use App\Application\Service\Task\PutTaskInQueueDto;
use App\Application\Service\Task\PutTaskInQueueServiceInterface;

class PutTaskInQueueService implements PutTaskInQueueServiceInterface
{
    public function __construct(private ProducerInterface $producer)
    {
    }

    public function put(PutTaskInQueueDto $dto): void
    {
        $message = json_encode($dto->toArray());
        $this->producer->publish($message);
    }
}
