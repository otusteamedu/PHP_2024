<?php

declare(strict_types=1);

namespace App\Shared\Console\Command;

use App\Shared\Search\SearchClientFactory;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class DeleteIndexCommand extends Command
{
    private const ARGUMENT_INDEX_NAME = 'index_name';

    protected function configure(): void
    {
        $this
            ->setName('index:delete')
            ->setDescription('Deletes index')
            ->addArgument(
                self::ARGUMENT_INDEX_NAME,
                InputArgument::REQUIRED,
                'The name of the index'
            )
            ->addUsage('otus-shop')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $indexName = $input->getArgument(self::ARGUMENT_INDEX_NAME);

        try {
            $client = (new SearchClientFactory())->make();

            $client->deleteIndex($indexName);

            return self::SUCCESS;
        } catch (Exception $e) {
            $output->writeln(sprintf('<error>Error: %s</error>', $e->getMessage()));

            return self::FAILURE;
        }
    }
}
