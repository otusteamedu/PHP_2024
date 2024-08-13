<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Command\Task;

use App\Application\UseCase\Exception\NotFoundException;
use App\Application\UseCase\Exception\RequestValidationException;
use App\Application\UseCase\Request\Task\ProcessTaskRequest;
use App\Application\UseCase\Task\ProcessTaskUseCase;
use App\Domain\Exception\ValidationException;
use App\Infrastructure\Service\Queue\ConsumerInterface;
use App\Infrastructure\Service\Queue\MessageInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'task-consumer:start')]
class TaskConsumerStartCommand extends Command
{
    public function __construct(
        private ProcessTaskUseCase $processTaskUseCase,
        private ConsumerInterface $consumer,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setDescription('Start task consumer');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Ожидание задач из очереди...' . PHP_EOL);
        $this->consumer->consume(function (MessageInterface $message) use ($output) {
            $this->processMessage($message, $output);
        });

        return Command::SUCCESS;
    }

    private function processMessage(MessageInterface $message, OutputInterface $output): void
    {
        $decodedBody = json_decode($message->getContent(), true);
        $taskId = $decodedBody['taskId'] ?? null;
        try {
            $output->writeln("Обработка задачи #$taskId...");
            ($this->processTaskUseCase)(new ProcessTaskRequest($taskId));
            $output->writeln("Задача #$taskId успешно обработана.");
            $message->ack();
        } catch (NotFoundException) {
            $output->writeln("Задача #$taskId не найдена!");
            $message->nack();
        } catch (RequestValidationException | ValidationException $e) {
            $output->writeln('Произошла ошибка!');
            $output->writeln(print_r($e->getErrors(), true));
            $message->nack();
        } finally {
            $output->writeln('');
        }
    }
}
