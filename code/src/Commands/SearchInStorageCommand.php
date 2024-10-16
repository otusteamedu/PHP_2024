<?php

namespace Naimushina\ElasticSearch\Commands;

use Naimushina\ElasticSearch\Collections\BookCollection;
use Naimushina\ElasticSearch\Repositories\BookRepository;
use Naimushina\ElasticSearch\Storages\ElasticSearchStorage;
use Naimushina\ElasticSearch\Storages\StorageInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SearchInStorageCommand extends Command
{
    const SEARCH_PARAM_JSON = 'params';

    /**
     * @param StorageInterface $storage
     */
    public function __construct(
        private StorageInterface $storage)
    {
        parent::__construct('search-in-storage');
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->addArgument(
            self::SEARCH_PARAM_JSON,
            InputArgument::REQUIRED,
            'Параметры для поиска в формате JSON'
        );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $jsonParams = $input->getArgument(self::SEARCH_PARAM_JSON);
        try {
            $params = json_decode($jsonParams, true, 10, JSON_THROW_ON_ERROR);
            $repository = new BookRepository();
            $result = $this->storage->search($repository, $params);
            if (count($result) > 0) {
                $books = new BookCollection($result);
                $dataToShow = $books->getItemsToShow();
                $headers = array_keys($dataToShow[0]);
                $table = new Table($output);
                $table->setHeaders($headers)->setRows($dataToShow)->render();
            } else {
                $output->writeln("По запросу  $jsonParams ничего не найдено ");
            }
            return self::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln("Ошибка поиска $jsonParams: " . $e->getMessage());
            return self::FAILURE;
        }

    }
}