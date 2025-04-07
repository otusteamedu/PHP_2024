<?php

namespace SergeyShirykalov\HomeworkRabbit\Application\AsyncHandler;

interface BankRequestHandlerInterface
{
    public function sendRequest(BankRequest $request): void;

}