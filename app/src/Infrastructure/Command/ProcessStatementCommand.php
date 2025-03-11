<?php

declare(strict_types=1);

namespace Otus\Hw20\Infrastructure\Command;

use Otus\Hw20\Application\Message\GenerateStatementMessage;
use Otus\Hw20\Domain\Repository\StatementRequestRepositoryInterface;
use Otus\Hw20\Infrastructure\Service\TelegramNotificationService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class ProcessStatementCommand extends Command
{
    protected static $defaultName = 'app:process-statements';

    public function __construct(
        private StatementRequestRepositoryInterface $repository,
        private TelegramNotificationService $telegramService
    ) {
        parent::__construct();
    }

    #[AsMessageHandler]
    public function handle(GenerateStatementMessage $message): void
    {
        $request = $this->repository->find($message->getRequestId());
        if (!$request) {
            return;
        }

        // Симуляция долгой обработки
        sleep(5);
        $request->setStatus('completed');
        $this->repository->save($request);

        // Отправка уведомления
        $this->telegramService->sendMessage(
            sprintf(
                "Statement generated for %s to %s",
                $request->getDateRange()->getStartDate()->format('Y-m-d'),
                $request->getDateRange()->getEndDate()->format('Y-m-d')
            )
        );
    }

    protected function configure(): void
    {
        // Дополнительно задаем имя и описание команды
        $this
            ->setName('app:process-statements')
            ->setDescription('Processes queued statement requests and sends notifications');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Waiting for messages...');
        return Command::SUCCESS;
    }
}
