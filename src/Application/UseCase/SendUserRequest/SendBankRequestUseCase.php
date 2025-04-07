<?php

namespace SergeyShirykalov\HomeworkRabbit\Application\UseCase\SendUserRequest;

use SergeyShirykalov\HomeworkRabbit\Application\AsyncHandler\BankRequestHandlerInterface;
use SergeyShirykalov\HomeworkRabbit\Application\AsyncHandler\BankRequest;

readonly class SendBankRequestUseCase
{
    public function __construct(
        private BankRequestHandlerInterface $userRequestHandler,
    )
    {
    }

    public function __invoke(SendBankRequestRequest $request): void
    {
        // создаем запрос
        $bankRequest = new BankRequest($request->getUserName(), $request->getEmail(), $request->getBody());

        // Отправляем запрос
        $this->userRequestHandler->sendRequest($bankRequest);
    }

}