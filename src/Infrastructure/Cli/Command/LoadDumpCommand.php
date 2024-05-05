<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\Command;

use Elastic\Elasticsearch\ClientInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:load-dump', description: 'Loading dump data')]
class LoadDumpCommand extends Command
{
    public function __construct(private ClientInterface $client)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument(
            'path',
            InputArgument::REQUIRED,
            "File path for dump"
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filePath = $input->getArgument('path');
        try {
            if (!file_exists($filePath)) {
                throw new \InvalidArgumentException("File not found");
            }
            $this->client->bulk(['body' => file_get_contents($filePath)]);
        } catch (\Throwable $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}
