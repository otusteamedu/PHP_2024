<?php

declare(strict_types=1);

namespace Pozys\BankStatement\Application\UseCase;

use Pozys\BankStatement\Application\DTO\{BankStatementRequest, Email};
use Pozys\BankStatement\Domain\Entity\BankStatementRepositoryInterface;
use Pozys\BankStatement\Domain\ValueObject\Date;

class ProcessBankStatementRequestUseCase implements MessageProcessable
{
    public function __construct(
        private BankStatementRepositoryInterface $repository,
        private Emailable $mailer
    ) {
    }

    public function __invoke(BankStatementRequest $request): void
    {
        $bankStatements = $this->getBankStatements($request);
        if (!$this->sendEmailNotification($bankStatements, $request->email)) {
            throw new \RuntimeException('Could not send email');
        }
    }

    private function getBankStatements(BankStatementRequest $request): array
    {
        return $this->repository->forPeriod(new Date($request->dateFrom), new Date($request->dateTo));
    }

    private function sendEmailNotification(array $bankStatements, string $email): bool
    {
        $email = $this->buildEmail($bankStatements, $email);

        return $this->mailer->send($email);
    }

    private function buildEmail(array $bankStatements, string $to): Email
    {
        return new Email(
            $to,
            'Bank statement report',
            json_encode($bankStatements)
        );
    }
}
