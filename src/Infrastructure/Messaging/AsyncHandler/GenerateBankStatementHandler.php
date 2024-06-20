<?php

declare(strict_types=1);

namespace Alogachev\Homework\Infrastructure\Messaging\AsyncHandler;

use Alogachev\Homework\Application\Messaging\AsyncHandler\AsyncHandlerInterface;
use Alogachev\Homework\Application\Messaging\Message\BankStatementRequestedMessage;
use Alogachev\Homework\Application\Messaging\Message\QueueMessageInterface;
use Alogachev\Homework\Domain\Entity\BankStatement;
use DateTime;
use Exception;

class GenerateBankStatementHandler implements AsyncHandlerInterface
{
    /**
     * @param BankStatementRequestedMessage $message
     *
     * @throws Exception
     */
    public function handle(QueueMessageInterface $message): void
    {
        $currentTimestamp = time();
        $statementFile = $message->getClientName() . '_' . $currentTimestamp . '.txt';
        $bankStatement = new BankStatement(
            $message->getClientName(),
            $message->getAccountNumber(),
            new DateTime($message->getStartDate()),
            new DateTime($message->getStartDate()),
            $statementFile,
        );
        // Далее здесь создаем файл выписки и отправляем на почту.
        echo "Сохранили выписку $statementFile для клиента " . $bankStatement->getClientName();
    }
}
