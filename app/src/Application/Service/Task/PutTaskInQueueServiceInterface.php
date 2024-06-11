<?php

declare(strict_types=1);

namespace App\Application\Service\Task;

interface PutTaskInQueueServiceInterface
{
    public function put(PutTaskInQueueDto $dto): void;
}
