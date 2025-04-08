<?php

namespace App\Infrastructure\AsyncHandler;

use App\Application\AsyncHandler\AsyncHandlerInterface;
use App\Application\AsyncHandler\LeadRequest;
use App\Infrastructure\RabbitClient;

class RabbitHandler implements AsyncHandlerInterface
{
    /**
     * @throws \Exception
     */
    public function __construct(
        private readonly RabbitClient $rabbitClient
    )
    {
    }

    public function sendRequest(LeadRequest $request): void
    {
        $msg = json_encode($request->toArray(), JSON_UNESCAPED_UNICODE);
        $this->rabbitClient->sendMessage($msg);
    }

}
