<?php

declare(strict_types=1);

namespace App\Analytics\Console\Command;

use App\Analytics\Factory\EventFactory;
use App\Analytics\Repository\EventRepositoryInterface;
use App\Analytics\Repository\RedisEventRepository;
use App\Analytics\Utility\EventParser;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CreateEventsCommand extends Command
{
    private const ARGUMENT_EVENT_DATA_AS_STRING = 'event_data_as_string';

    private readonly EventParser $eventParser;
    private readonly EventFactory $eventFactory;
    private readonly EventRepositoryInterface $eventRepository;

    public function __construct(?string $name = null)
    {
        $this->eventParser = new EventParser();
        $this->eventFactory = new EventFactory();
        $this->eventRepository = new RedisEventRepository();

        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setName('analytics:events:create')
            ->setDescription('Creates new event')
            ->addArgument(
                self::ARGUMENT_EVENT_DATA_AS_STRING,
                InputArgument::REQUIRED,
                'The event data as string'
            )
            ->addUsage('"{priority: 1000, conditions: {param1 = 1}, name: event_1}"')
            ->addUsage('"{priority: 2000, conditions: {param1 = 1, param2 = 2}, name: event_2}"')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $data = $this->eventParser->parse(
                $input->getArgument(self::ARGUMENT_EVENT_DATA_AS_STRING)
            );

            $event = $this->eventFactory->makeFromArray($data);

            $this->eventRepository->save($event);
        } catch (Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));

            return self::FAILURE;
        }

        $output->writeln(
            sprintf(
                '<info>The event with name [%s] has been successfully created</info>',
                $event->name
            )
        );

        return self::SUCCESS;
    }
}
