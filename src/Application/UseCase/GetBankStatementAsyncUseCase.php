<?php

declare(strict_types=1);

namespace Pozys\BankStatement\Application\UseCase;

use Pozys\BankStatement\Application\DTO\BankStatementRequest;

class GetBankStatementAsyncUseCase
{
    public function __construct(private MessageBrokerInterface $messageBroker)
    {
    }

    public function __invoke(BankStatementRequest $request): void
    {
        $data = [
            'from' => $request->dateFrom,
            'to' => $request->dateTo,
            'email' => $request->email
        ];

        $this->pushToQueue($data);
    }

    private function pushToQueue(array $data): void
    {
        $this->messageBroker->publish($data);
    }
}
