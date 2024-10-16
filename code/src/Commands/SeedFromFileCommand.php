<?php

namespace Naimushina\ElasticSearch\Commands;

use Naimushina\ElasticSearch\Storages\StorageInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SeedFromFileCommand extends Command
{
    const FILE_ARG_NAME = 'file';

    public function __construct(private StorageInterface $storage)
    {
        parent::__construct('seed-from-file');
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->addArgument(
            self::FILE_ARG_NAME,
            InputArgument::REQUIRED,
            'Путь до файла для загрузки'
        );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $fileName = $input->getArgument(self::FILE_ARG_NAME);
        try {
            $result = $this->storage->seedFromFile($fileName);
            $items = $result['items'] ?? [];
            $totalCount = count($items);
            $errorMsgs = "";
            $errorCount = 0;
            foreach ($items as $item) {
                $status = array_values($item)[0] ?? [];
                $error = $status['error'] ?? null;
                if ($error) {
                    $errorCount++;
                    $errorMsgs .= "Ошибка добавления : " . $error['reason'] . PHP_EOL;
                }
            }
            $added = $totalCount - $errorCount;
            $output->writeln("Добавлено $added из $totalCount");
            $output->writeln($errorMsgs);
            return self::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln("Ошибка добавления данных из файла $fileName : " . $e->getMessage());
            return self::FAILURE;
        }

    }
}