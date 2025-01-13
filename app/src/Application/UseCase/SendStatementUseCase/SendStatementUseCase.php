<?php

namespace App\Application\UseCase\SendStatementUseCase;

use App\Domain\Entity\Transaction;
use App\Domain\Repository\AccountRepositoryInterface;
use App\Domain\Repository\StatementRepositoryInterface;
use App\Domain\ValueObject\Status;
use App\Infrastructure\Entity\StatusEnum;
use Exception;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class SendStatementUseCase
{
    public function __construct(
        private MailerInterface $mailer,
        private AccountRepositoryInterface $accountRepository,
        private StatementRepositoryInterface $statementRepository
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function __invoke(SendStatementRequest $request): SendStatementResponse
    {
        $statement = $request->statement;
        $account = $this->accountRepository->findById($statement->getAccount()->getValue());
        $subject = 'Account Statement for account number '
            . $statement->getAccount()->getValue()
            . ' from ' . $statement->getDateFrom()->getValue()
            . ' to ' . $statement->getDateFrom()->getValue();

        $email = (new TemplatedEmail())
            ->from('statements@otus.com')
            ->to($account->getHolderEmail()->getValue())
            ->subject($subject)
            ->htmlTemplate('statement.html.twig')
            ->context([
                'accountNumber' => $statement->getAccount()->getValue(),
                'transactions' => array_map(function (Transaction $transaction) {
                    $amountNumber = $transaction->getAmount()->getValue();
                    $amountSign = $transaction->getTransactionType()->getValue() === "1" ? '+' : '-';
                    return [
                        'created_at' => $transaction->getDate(),
                        'description' => $transaction->getDescription()->getValue(),
                        'amount' => $amountSign . $amountNumber
                    ];
                }, $statement->getTransactions()),
            ]);
        try {
            $this->mailer->send($email);
            $statement->setStatus(new Status(StatusEnum::Done->value));
            $this->statementRepository->save($statement);
            $result = true;
        } catch (Exception $exception) {
            $result = false;
            $statement->setStatus(new Status(StatusEnum::Error->value));
            $this->statementRepository->save($statement);
        }

        return new SendStatementResponse(
            $result
        );
    }
}
