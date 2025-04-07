<?php

namespace SergeyShirykalov\HomeworkRabbit\Infrastructure\AsyncHandler;

use SergeyShirykalov\HomeworkRabbit\Application\AsyncHandler\BankRequest;
use SergeyShirykalov\HomeworkRabbit\Application\AsyncHandler\BankRequestHandlerInterface;
use SergeyShirykalov\HomeworkRabbit\Infrastructure\RabbitClient;

class RabbitHandler implements BankRequestHandlerInterface
{

    public function __construct(
        private readonly RabbitClient $rabbitClient,
    )
    {
    }

    public function sendRequest(BankRequest $request): void
    {
        $msg = json_encode($request->toArray(), JSON_UNESCAPED_UNICODE);
        $this->rabbitClient->sendMessage($msg);
    }

}