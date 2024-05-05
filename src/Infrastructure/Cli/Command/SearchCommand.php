<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\Command;

use App\Application\Response\SearchProductResponse;
use App\Application\UseCase\SearchProductsUseCase;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:search', description: 'Search by shop')]
class SearchCommand extends Command
{
    public function __construct(private SearchProductsUseCase $useCase)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument(
            'search',
            InputArgument::IS_ARRAY | InputArgument::REQUIRED,
            "Search condition.
            Example: \"title=книга роман\" \"price>10\".
            Allowed comparison operations:
            = - Exact match
            * - Full text search
            > - Greater than
            < - Lower than"
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $conditions = $input->getArgument('search');
        try {
            $products = ($this->useCase)($conditions);
            $table = new Table($output);
            $table
                ->setHeaderTitle('Products')
                ->setHeaders(['Id', 'Title', 'Category', 'Price', 'Stock'])
                ->setRows(
                    array_map(
                        static fn (SearchProductResponse $product) => [
                            $product->id,
                            $product->title,
                            $product->category,
                            $product->price,
                            $product->stock
                        ],
                        $products
                    )
                );
            $table->render();
        } catch (\Throwable $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}
