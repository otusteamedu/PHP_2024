<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:search-book',
    description: 'Add a short description for your command',
)]
class SearchBookCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('query', null, InputOption::VALUE_OPTIONAL, 'Option for "Search query"')
            ->addOption('gte', null, InputOption::VALUE_OPTIONAL, 'Option for "Greater than"')
            ->addOption('lte', null, InputOption::VALUE_OPTIONAL, 'Option for "Less than"')
            ->addOption('category', null, InputOption::VALUE_OPTIONAL, 'Option for "Category"')
            ->addOption('shop', null, InputOption::VALUE_OPTIONAL, 'Option for "Shop"')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if ($query = $input->getOption('query')) {
            $io->note(sprintf('Search query: %s', $query));
        }
        if ($gte = $input->getOption('gte')) {
            $io->note(sprintf('Greater than: %s', $gte));
        }
        if ($lte = $input->getOption('lte')) {
            $io->note(sprintf('Less than: %s', $lte));
        }
        if ($category = $input->getOption('category')) {
            $io->note(sprintf('Category: %s', $category));
        }
        if ($shop = $input->getOption('shop')) {
            $io->note(sprintf('Shop: %s', $shop));
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
