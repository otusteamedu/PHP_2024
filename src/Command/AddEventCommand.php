<?php

declare(strict_types=1);

namespace App\Command;

use App\EventStorageInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddEventCommand extends Command
{
    public function __construct(private readonly EventStorageInterface $eventStorageService)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:add-event')
            ->setDescription('Добавляет новое событие')
            ->addArgument('eventData', InputArgument::REQUIRED, 'Данные события в формате JSON');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $eventJson = $input->getArgument('eventData');

        $event = json_decode($eventJson, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $output->writeln('Ошибка при разборе данных JSON.');
            return Command::FAILURE;
        }

        if (!isset($event['priority'], $event['conditions'], $event['event'])) {
            $output->writeln('Необходимые ключи: priority, conditions, event.');
            return Command::FAILURE;
        }

        $this->eventStorageService->add($event);

        $output->writeln('Событие успешно добавлено.');
        return Command::SUCCESS;
    }
}
