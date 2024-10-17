<?php

declare(strict_types=1);

namespace App\Analytics\Console\Command;

use App\Analytics\Repository\EventRepositoryInterface;
use App\Analytics\Repository\RedisEventRepository;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ClearEventsCommand extends Command
{
    private readonly EventRepositoryInterface $eventRepository;

    public function __construct(?string $name = null)
    {
        $this->eventRepository = new RedisEventRepository();

        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setName('analytics:events:clear')
            ->setDescription('Clears the events storage')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->eventRepository->clear();
        } catch (Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));

            return self::FAILURE;
        }

        $output->writeln('<info>The events storage has been cleared</info>');

        return self::SUCCESS;
    }
}
