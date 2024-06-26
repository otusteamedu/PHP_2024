<?php

declare(strict_types=1);

namespace Alogachev\Homework\Application\UseCase;

use Alogachev\Homework\Application\Messaging\Message\BankStatementRequestedMessage;
use Alogachev\Homework\Application\Messaging\Producer\ProducerInterface;
use Alogachev\Homework\Application\Render\RenderInterface;
use Alogachev\Homework\Application\UseCase\Request\GenerateBankStatementRequest;
use Alogachev\Homework\Domain\Entity\BankStatement;
use Alogachev\Homework\Domain\Enum\BankStatementStatusEnum;
use Alogachev\Homework\Domain\Repository\BankStatementRepositoryInterface;
use Alogachev\Homework\Domain\ValueObject\BankStatementStatus;
use DateTime;
use Exception;

class GenerateBankStatementUseCase
{
    public function __construct(
        private readonly RenderInterface $render,
        private readonly ProducerInterface $producer,
        private readonly BankStatementRepositoryInterface $statementRepository,
    ) {
    }

    /**
     * ToDo: Добавить дто ответа.
     *
     * @throws Exception
     */
    public function __invoke(GenerateBankStatementRequest $request): void
    {
        $bankStatement = new BankStatement(
            $request->clientName,
            $request->accountNumber,
            new DateTime($request->startDate),
            new DateTime($request->endDate),
            null,
            new BankStatementStatus(BankStatementStatusEnum::Preparing->value),
        );
        $id = $this->statementRepository->save($bankStatement);

        $message = new BankStatementRequestedMessage($id);
        $this->producer->sendMessage($message);

        $this->render->render('success-generated.php');
    }
}
