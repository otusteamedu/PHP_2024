<?php

declare(strict_types=1);

namespace Alogachev\Homework\Application\UseCase;

use Alogachev\Homework\Application\Messaging\Message\BankStatementRequestedMessage;
use Alogachev\Homework\Application\Messaging\Producer\ProducerInterface;
use Alogachev\Homework\Application\Render\RenderInterface;
use Alogachev\Homework\Application\UseCase\Request\GenerateBankStatementRequest;

class GenerateBankStatementUseCase
{
    public function __construct(
        private readonly RenderInterface $render,
        private readonly ProducerInterface $producer,
    ) {
    }

    public function __invoke(GenerateBankStatementRequest $request): void
    {


        $message = new BankStatementRequestedMessage(
            $request->clientName,
            $request->accountNumber,
            $request->startDate,
            $request->endDate,
        );
        $this->producer->sendMessage($message);

        $this->render->render('success-generated.php');
    }
}
