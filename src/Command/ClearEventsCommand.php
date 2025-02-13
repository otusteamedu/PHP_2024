<?php

declare(strict_types=1);

namespace App\Command;

use App\EventStorageInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearEventsCommand extends Command
{
    public function __construct(private readonly EventStorageInterface $eventStorageService)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:clear-events')
            ->setDescription('Удаляет все события');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->eventStorageService->clear();
        $output->writeln('Все события были очищены.');
        return Command::SUCCESS;
    }
}