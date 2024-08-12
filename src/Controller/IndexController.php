<?php

declare(strict_types=1);

namespace App\Controller;

use App\Convertor\RequestProcessToStringConverter;
use App\Queue\Message\RequestProcessQueueMessage;
use App\Queue\QueueInterface;
use App\Repository\RequestProcessRepositoryInterface;

class IndexController
{
    public function __construct(
        private readonly QueueInterface $queue,
        private readonly RequestProcessRepositoryInterface $repository
    ) {
    }

    public function index(int $id = 0): string
    {
        if ($id > 0) {
            $entity = $this->repository->findById($id);
            if (null === $entity) {
                throw new \DomainException('Request not found');
            }
            return RequestProcessToStringConverter::toString($entity);
        }

        $entity = $this->repository->add();
        $message = new RequestProcessQueueMessage($entity->getId());
        $this->queue->push($message);

        return RequestProcessToStringConverter::toString($entity);
    }
}
