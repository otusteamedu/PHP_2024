<?php

declare(strict_types=1);

namespace App\Infrastructure\Messenger;

use App\Domain\Event\StatementPersistedEvent;
use App\Domain\Service\BankStatementMailerInterface;
use App\Infrastructure\Persistence\Doctrine\Repository\DoctrineBankStatementRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class BankStatementPersistedEventHandler
{
    public function __construct(
        private BankStatementMailerInterface $mailer,
        private DoctrineBankStatementRepository $repository
    ) {
    }

    public function __invoke(StatementPersistedEvent $event): void
    {
        $bankStatements = $this->repository->findInRange(
            $event->getAccount(),
            $event->getDateFrom(),
            $event->getDateTo()
        );

        sleep(5); // имитация задержки

        $this->mailer->sendBankStatement($bankStatements);
    }
}
