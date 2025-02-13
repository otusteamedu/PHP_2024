<?php

declare(strict_types=1);

namespace App\Command;

use App\EventStorageInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MatchingEventCommand extends Command
{
    public function __construct(private readonly EventStorageInterface $eventStorageService)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:match-event')
            ->setDescription('Возвращает событие по условию')
            ->addArgument(
                'params',
                InputArgument::REQUIRED,
                'Данные события в формате JSON - params: {
                    param1 = 1,
                    param2 = 2
                }');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $paramsJson = $input->getArgument('params');

        $params = json_decode($paramsJson, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $output->writeln('Ошибка при разборе данных JSON.');
            return Command::FAILURE;
        }

        if (!isset($params['params'])) {
            $output->writeln('Необходимый ключ: params');
            return Command::FAILURE;
        }

        $result = $this->eventStorageService->get($params['params']);

        $output->writeln(json_encode($result));
        return Command::SUCCESS;
    }
}