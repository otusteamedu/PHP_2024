<?php

declare(strict_types=1);

namespace App\Application\Gateway;

interface QueueGatewayInterface
{
    public function sendTask(QueueGatewayRequest $request): void;
}
