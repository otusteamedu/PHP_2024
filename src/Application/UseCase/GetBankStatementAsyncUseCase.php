<?php

declare(strict_types=1);

namespace Pozys\BankStatement\Application\UseCase;

use Pozys\BankStatement\Domain\ValueObject\{Date, Email};

class GetBankStatementAsyncUseCase
{
    public function __construct(private MessageBrokerInterface $messageBroker)
    {
    }

    public function __invoke(Date $from, Date $to, Email $email)
    {
        $data = compact('from', 'to', 'email');
        $this->pushToQueue($data);
    }

    private function pushToQueue(array $data): void
    {
        $this->messageBroker->publish($data);
    }
}
