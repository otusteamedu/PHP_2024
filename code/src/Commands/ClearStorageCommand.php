<?php

namespace Naimushina\ElasticSearch\Commands;

use Naimushina\ElasticSearch\Storages\ElasticSearchStorage;
use Naimushina\ElasticSearch\Storages\StorageInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearStorageCommand extends Command
{
    /**
     * @param StorageInterface $storage
     */
    public function __construct(private StorageInterface $storage)
    {
        parent::__construct('clear_storage');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $indexName = $this->storage->indexName;
        try {
            $this->storage->clear();
            $output->writeln("Индекс $indexName успешно удален");
            return self::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln("Ошибка удаления $indexName: " . $e->getMessage());
            return self::FAILURE;
        }
    }
}