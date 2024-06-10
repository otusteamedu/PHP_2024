<?php

declare(strict_types=1);

namespace App\Application\Queue;

use App\Application\Queue\Request\QueueRequest;

interface QueueJobInterface
{
    public function push(QueueRequest $request): void;
}
