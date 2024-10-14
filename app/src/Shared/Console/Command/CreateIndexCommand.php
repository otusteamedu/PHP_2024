<?php

declare(strict_types=1);

namespace App\Shared\Console\Command;

use App\Shared\Search\SearchClientFactory;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CreateIndexCommand extends Command
{
    private const ARGUMENT_INDEX_NAME = 'index_name';
    private const ARGUMENT_SCHEMA_PATH = 'schema_path';

    protected function configure(): void
    {
        $this
            ->setName('index:create')
            ->setDescription('Creates index')
            ->addArgument(
                self::ARGUMENT_INDEX_NAME,
                InputArgument::REQUIRED,
                'The name of the index'
            )
            ->addArgument(
                self::ARGUMENT_SCHEMA_PATH,
                InputArgument::OPTIONAL,
                'The absolute path to the index schema file'
            )
            ->addUsage('otus-shop')
            ->addUsage('otus-shop /data/var/import/schema.json')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $indexName = $input->getArgument(self::ARGUMENT_INDEX_NAME);
        $indexSchemaPath = $input->getArgument(self::ARGUMENT_SCHEMA_PATH);

        try {
            $client = (new SearchClientFactory())->make();

            $indexSchema = $indexSchemaPath
                ? json_decode(file_get_contents($indexSchemaPath), true)
                : [];

            $client->createIndex($indexName, $indexSchema);

            return self::SUCCESS;
        } catch (Exception $e) {
            $output->writeln(sprintf('<error>Error: %s</error>', $e->getMessage()));

            return self::FAILURE;
        }
    }
}
