<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Application\Gateway\QueueGatewayRequest;
use App\Domain\Repository\BankStatementRepositoryInterface;

#[AsMessageHandler]
class TasksHandler implements MessageHandlerInterface
{
    public function __construct(private BankStatementRepositoryInterface $statementRepository)
    {
    }

    public function __invoke(QueueGatewayRequest $request)
    {
        $id = $request->id;
        #установим статус обработки в in_process
        $this->statementRepository->setStatusProcess($id);
        print_r("Set process status for task = " . $id . PHP_EOL);

        #иммитация какой-то обработки данных в течении 15 секунд
        sleep(15);

        #установим статус в done
        $this->statementRepository->setStatusDone($id);
        print_r("Set done status for task = " . $id . PHP_EOL);
    }
}
