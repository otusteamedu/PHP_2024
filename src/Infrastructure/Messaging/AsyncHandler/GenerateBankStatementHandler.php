<?php

declare(strict_types=1);

namespace Alogachev\Homework\Infrastructure\Messaging\AsyncHandler;

use Alogachev\Homework\Application\Exception\BankStatementNotFound;
use Alogachev\Homework\Application\Messaging\AsyncHandler\AsyncHandlerInterface;
use Alogachev\Homework\Application\Messaging\Message\BankStatementRequestedMessage;
use Alogachev\Homework\Application\Messaging\Message\QueueMessageInterface;
use Alogachev\Homework\Domain\Repository\BankStatementRepositoryInterface;
use Alogachev\Homework\Domain\Repository\Query\FindBankStatementQuery;
use Alogachev\Homework\Domain\Repository\Query\UpdateStatusToReadyQuery;
use Exception;

class GenerateBankStatementHandler implements AsyncHandlerInterface
{
    public function __construct(
        private readonly BankStatementRepositoryInterface $statementRepository,
    ) {
    }

    /**
     * @param BankStatementRequestedMessage $message
     *
     * @throws Exception
     */
    public function handle(QueueMessageInterface $message): void
    {
        $bankStatement = $this->statementRepository->findById(new FindBankStatementQuery($message->id));

        if (is_null($bankStatement)) {
            throw new BankStatementNotFound();
        }

        $currentTimestamp = time();
        $statementFile = $bankStatement->getClientName() . '_' . $currentTimestamp . '.txt';

        // Далее здесь создаем файл выписки и "отправляем на почту".
        echo "Сформировали выписку $statementFile для клиента " . $bankStatement->getClientName() . PHP_EOL;

        $this->statementRepository->updateStatus(
            new UpdateStatusToReadyQuery(
                $bankStatement->getId(),
                $statementFile,
            )
        );

        echo "Выписка $statementFile для клиента " . $bankStatement->getClientName() . " сохранена в БД" . PHP_EOL;
    }
}
