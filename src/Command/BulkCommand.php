<?php

namespace KRudenko\Otus\Command;

use JsonException;
use KRudenko\Otus\Service\ElasticService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('app:bulk', 'Bulk documents in Elasticsearch')]
class BulkCommand extends Command
{
    public function __construct(
        private readonly ElasticService $elasticService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('path', InputArgument::OPTIONAL, 'path to JSON document for index', $_ENV['INDEX_FILE_PATH']);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $path = $input->getArgument('path');
            if (!file_exists($path)) {
                $output->writeln('<error>File Not Found: ' . $path . '</error>');

                return Command::FAILURE;
            }

            $document = json_decode(file_get_contents($path), true, flags: JSON_THROW_ON_ERROR);

            $result = $this->elasticService->bulk($document);

            if ($result) {
                $output->writeln('Document indexed successfully!');
            } else {
                $output->writeln('Document indexed failed!');
            }

            return Command::SUCCESS;
        } catch (JsonException $e) {
            $output->writeln('<error>Invalid JSON format: ' . $e->getMessage() . '</error>');

            return Command::FAILURE;
        }
    }
}
