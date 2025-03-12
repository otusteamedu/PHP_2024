<?php

declare(strict_types=1);

namespace PavelMiasnov\MediaMonitoring\Infrastructure\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use PavelMiasnov\MediaMonitoring\Application\UseCase\CreateNews\CreateNewsRequest;
use PavelMiasnov\MediaMonitoring\Application\UseCase\CreateNews\CreateNewsUseCase;

#[AsCommand(name: 'app:create-news')]
class CreateNewsCommand extends Command
{
    public function __construct(
        private CreateNewsUseCase $createNewsUseCase,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Create a news entry from a given URL')
            ->addArgument('url', InputArgument::REQUIRED, 'The URL of the news page');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $createNewsRequest = new CreateNewsRequest(
                $input->getArgument('url')
            );
            $createNewsResponse = ($this->createNewsUseCase)($createNewsRequest);
            $output->writeln('News created with ID: ' . $createNewsResponse->getNewsId());
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }
    }
}
