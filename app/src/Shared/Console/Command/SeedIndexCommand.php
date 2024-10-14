<?php

declare(strict_types=1);

namespace App\Shared\Console\Command;

use App\Shared\Search\SearchClientFactory;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SeedIndexCommand extends Command
{
    private const ARGUMENT_INDEX_NAME = 'index_name';
    private const ARGUMENT_DATA_PATH = 'data_path';

    protected function configure(): void
    {
        $this
            ->setName('index:seed')
            ->setDescription('Seeds index with provided data')
            ->addArgument(
                self::ARGUMENT_INDEX_NAME,
                InputArgument::REQUIRED,
                'The name of the index to seed'
            )
            ->addArgument(
                self::ARGUMENT_DATA_PATH,
                InputArgument::REQUIRED,
                'The absolute path to the data file'
            )
            ->addUsage('otus-shop /data/var/import/books.json')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $indexName = $input->getArgument(self::ARGUMENT_INDEX_NAME);
        $dataPath = $input->getArgument(self::ARGUMENT_DATA_PATH);

        try {
            $client = (new SearchClientFactory())->make();

            $client->bulk(
                $indexName,
                ['data-binary' => file_get_contents($dataPath)]
            );

            return self::SUCCESS;
        } catch (Exception $e) {
            $output->writeln(sprintf('<error>Error: %s</error>', $e->getMessage()));

            return self::FAILURE;
        }
    }
}
