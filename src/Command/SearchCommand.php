<?php

namespace KRudenko\Otus\Command;

use Exception;
use KRudenko\Otus\Service\ElasticService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('app:search', 'Search in Elasticsearch')]
class SearchCommand extends Command
{
    public function __construct(
        private readonly ElasticService $elasticService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('title', 't', InputOption::VALUE_OPTIONAL, 'Поиск по названию книги. Пример: `-t "Поиск книг"`', '')
            ->addOption('price', 'p', InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'Поиск по цене. Можно указать операцию `=,<,>,<=,>=` и сумму, можно указать несколько цен, буду браться только первые 2. Если будет указана цена без операции, то будет использоваться `=`. Пример: `-p "=100"` или две цены `-p ">=100" -p "<200"`.')
            ->addOption('is_comment', 'c', InputOption::VALUE_NEGATABLE, 'Будут показаны книги только с комментариями. Пример: `-c`.', false)
            ->addOption('page', null, InputOption::VALUE_OPTIONAL, 'Номер страницы', 1)
            ->setHelp(sprintf('Если опции не указывать, будут выведены первые %d книг', $_ENV['PAGE_SIZE']));
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $title = $input->getOption('title');
            $price = $input->getOption('price');
            $inComment = $input->getOption('is_comment');
            $page = $input->getOption('page');

            $results = $this->elasticService->search($title, $price, $inComment, $page);

            $output->writeln("Search results:");
            $output->writeln(json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

            return Command::SUCCESS;
        } catch (Exception $e) {
            $output->writeln('<error>Search failed: ' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }
    }
}
