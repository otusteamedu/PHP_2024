<?php

declare(strict_types=1);

namespace App\Shared\Console\Command;

use PDO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExecuteDatabaseImportCommand extends Command
{
    private const ARGUMENT_IMPORT_FILE_PATH = 'import_file_path';

    public function __construct(
        private readonly PDO $pdo,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setName('database:import')
            ->setDescription('Imports the SQL file into database')
            ->addArgument(
                self::ARGUMENT_IMPORT_FILE_PATH,
                InputArgument::REQUIRED,
                'File path'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filePath = $input->getArgument(self::ARGUMENT_IMPORT_FILE_PATH);

        if (!file_exists($filePath)) {
            $output->writeln('<error>Import file path is invalid</error>');

            return self::FAILURE;
        }

        if (false === $this->pdo->exec(file_get_contents($filePath))) {
            $output->writeln('<error>Could not import file</error>');

            return self::FAILURE;
        }

        $output->writeln('<info>The SQL file has been imported</info>');

        return self::SUCCESS;
    }
}
