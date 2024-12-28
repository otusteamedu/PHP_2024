<?php

namespace App\Infostructure\Command;

use App\Application\UseCase\ShowDirectory\ShowDirectoryUseCase;
use App\Domain\ValueObject\Path;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:show-directory')]
class ShowDirectoryCommand extends Command
{
    public function __construct(
        private readonly ShowDirectoryUseCase $useCase,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('path', InputArgument::REQUIRED, 'Absolute path of directory to show');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $showDirectoryRequest = new \ShowDirectoryRequest(
                new Path($input->getArgument('path'))
            );
            $showDirectoryResponse  = ($this->useCase)($showDirectoryRequest);
            $output->writeln($showDirectoryResponse);
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }
    }


}