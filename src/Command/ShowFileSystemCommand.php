<?php

declare(strict_types=1);

namespace App\Command;

use App\Handlers\FileHandler;
use App\Handlers\SizeHandler;
use App\ShowDirectory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShowFileSystemCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('app:show-file-system')
            ->setDescription('Вывод файлов и папок в директории')
            ->addArgument('path', InputArgument::REQUIRED, 'Путь до директории');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $path = $input->getArgument('path');

            $handler = new FileHandler();
            $handler->next(new SizeHandler(102400));

            $output->writeln(
                (new ShowDirectory($path, $handler))->show()
            );
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }
    }
}
