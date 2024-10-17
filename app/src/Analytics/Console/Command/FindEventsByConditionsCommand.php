<?php

declare(strict_types=1);

namespace App\Analytics\Console\Command;

use App\Analytics\Factory\EventConditionsFactory;
use App\Analytics\Repository\EventRepositoryInterface;
use App\Analytics\Repository\RedisEventRepository;
use App\Analytics\Utility\EventConditionsParser;
use App\Analytics\Utility\EventFormatter;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class FindEventsByConditionsCommand extends Command
{
    private const ARGUMENT_EVENT_CONDITIONS_AS_STRING = 'event_conditions_as_string';

    private readonly EventConditionsParser $eventConditionsParser;
    private readonly EventConditionsFactory $eventConditionsFactory;
    private readonly EventRepositoryInterface $eventRepository;
    private readonly EventFormatter $eventFormatter;

    public function __construct(?string $name = null)
    {
        $this->eventConditionsParser = new EventConditionsParser();
        $this->eventConditionsFactory = new EventConditionsFactory();
        $this->eventRepository = new RedisEventRepository();
        $this->eventFormatter = new EventFormatter();

        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setName('analytics:events:find')
            ->setDescription('Creates new event')
            ->addArgument(
                self::ARGUMENT_EVENT_CONDITIONS_AS_STRING,
                InputArgument::REQUIRED,
                'The event conditions as string'
            )
            ->addUsage('"{conditions: {param1 = 1, param2 = 2}}"')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $conditions = $this->eventConditionsParser->parse(
                $input->getArgument(self::ARGUMENT_EVENT_CONDITIONS_AS_STRING)
            );

            $conditions = $this->eventConditionsFactory->makeFromArray($conditions);

            $event = $this->eventRepository->findByConditions(...$conditions->all());
        } catch (Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));

            return self::FAILURE;
        }

        if (null === $event) {
            $output->writeln('<info>The event matching provided conditions not found</info>');

            return self::INVALID;
        }

        $table = $this->eventFormatter->toTable($event);

        (new Table($output))
            ->setHeaders($table['headers'])
            ->setRows($table['rows'])
            ->render()
        ;

        return self::SUCCESS;
    }
}
