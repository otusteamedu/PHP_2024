<?php

declare(strict_types=1);

namespace App\Shop\Console\Command;

use App\Shared\Search\Filter\RangeFilter;
use App\Shared\Search\Filter\SimpleFilter;
use App\Shared\Search\SearchClientFactory;
use App\Shared\Search\SearchCriteria;
use App\Shop\Model\Book;
use App\Shop\Repository\BookRepository;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class SearchBookCommand extends Command
{
    private const OPTION_TITLE = 'title';
    private const OPTION_SKU = 'sku';
    private const OPTION_CATEGORY = 'category';
    private const OPTION_PRICE_MIN = 'price_min';
    private const OPTION_PRICE_MAX = 'price_max';
    private const OPTION_IN_STOCK = 'in_stock';

    protected function configure(): void
    {
        $this
            ->setName('shop:search-book')
            ->setDescription('Search books')
            ->addOption(
                self::OPTION_TITLE,
                null,
                InputOption::VALUE_OPTIONAL,
                'Search by title'
            )
            ->addOption(
                self::OPTION_SKU,
                null,
                InputOption::VALUE_OPTIONAL,
                'Search by SKU'
            )
            ->addOption(
                self::OPTION_CATEGORY,
                null,
                InputOption::VALUE_OPTIONAL,
                'Search by category'
            )
            ->addOption(
                self::OPTION_PRICE_MIN,
                null,
                InputOption::VALUE_OPTIONAL,
                'Search by min. price'
            )
            ->addOption(
                self::OPTION_PRICE_MAX,
                null,
                InputOption::VALUE_OPTIONAL,
                'Search by max. price'
            )
            ->addOption(
                self::OPTION_IN_STOCK,
                null,
                InputOption::VALUE_OPTIONAL,
                'Search by stock status'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $searchClient = (new SearchClientFactory())->make();
            $bookRepository = new BookRepository($searchClient);

            $results = $bookRepository->search($this->makeSearchCriteria($input));

            (new Table($output))
                ->setHeaders(['Title', 'SKU', 'Category', 'Price', 'Stock'])
                ->setRows($this->makeTableRows($results->getItems()))
                ->render()
            ;

            return self::SUCCESS;
        } catch (Exception $e) {
            $output->writeln(sprintf('<error>Error: %s</error>', $e->getMessage()));

            return self::FAILURE;
        }
    }

    private function makeSearchCriteria(InputInterface $input): SearchCriteria
    {
        $title = $input->getOption(self::OPTION_TITLE);
        $sku = $input->getOption(self::OPTION_SKU);
        $category = $input->getOption(self::OPTION_CATEGORY);
        $priceMin = $input->getOption(self::OPTION_PRICE_MIN);
        $priceMax = $input->getOption(self::OPTION_PRICE_MAX);
        $inStock = $input->getOption(self::OPTION_IN_STOCK);

        $filters = [];

        $title && $filters[] = new SimpleFilter('title', 'LIKE', $title);
        $sku && $filters[] = new SimpleFilter('sku', '=', $sku);
        $category && $filters[] = new SimpleFilter('category', '=', $category);

        if (null !== $priceMin || null !== $priceMax) {
            $priceMinFilter = (null === $priceMin) ? null : new SimpleFilter('price_min', 'gte', $priceMin);
            $priceMaxFilter = (null === $priceMax) ? null : new SimpleFilter('price_max', 'lte', $priceMax);

            $filters[] = new RangeFilter(
                'price', $priceMinFilter ?? $priceMaxFilter, $priceMaxFilter ?? $priceMinFilter
            );
        }

        if (null !== $inStock) {
            $inStockFilter = new SimpleFilter('in_stock', $inStock ? 'gt' : 'gte', '0');

            $filters[] = new RangeFilter('stock.stock', $inStockFilter);
        }

        return new SearchCriteria($filters);
    }

    private function makeTableRows(array $items): array
    {
        return array_map(function (Book $book) {
            return [
                $book->title,
                $book->sku,
                $book->category,
                $book->price,
                $book->getTotalStockCount(),
            ];
        }, $items);
    }
}