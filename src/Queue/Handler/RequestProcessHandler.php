<?php

declare(strict_types=1);

namespace App\Queue\Handler;

use App\Queue\Message\RequestProcessQueueMessage;
use App\Repository\RequestProcessRepository;
use Ramsey\Uuid\Uuid;

readonly class RequestProcessHandler
{
    public function __construct(private RequestProcessRepository $repository)
    {
    }

    public function __invoke(RequestProcessQueueMessage $message): void
    {
        sleep(10);
        $this->repository->update($message->requestId, Uuid::uuid6()->toString());
    }
}