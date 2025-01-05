<?php

namespace App\Command;

use App\Service\SearchServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:es:search',
    description: 'search items in es',
)]
class EsSearchCommand extends Command
{
    public function __construct(private readonly SearchServiceInterface $elasticsearchService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $helper = $this->getHelper('question');
        $question = new Question('Введите название товара: ', '');
        if ($title = $helper->ask($input, $output, $question)) {
            $params['title'] = $title;
        }

        $question = new Question('Введите название категории товара: ', '');
        if ($category = $helper->ask($input, $output, $question)) {
            $params['category'] = $category;
        }

        $question = new Question('Введите sku: ', '');
        if ($sku = $helper->ask($input, $output, $question)) {
            $params['sku'] = $sku;
        }

        if (!empty($params)) {
            $result = $this->elasticsearchService->search($params);
            foreach ($result as $item) {
                $io->writeln($item);
            }
        }

        return Command::SUCCESS;
    }
}
