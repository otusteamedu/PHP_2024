<?php

declare(strict_types=1);

namespace App\Console\Command;

use App\Search\ClientFactory;
use App\Search\Data;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class SearchCommand extends Command
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
            ->setName('search')
            ->setDescription('Creates and seeds default search storage')
            ->addOption(self::OPTION_TITLE, null, InputOption::VALUE_OPTIONAL, 'Search by title')
            ->addOption(self::OPTION_SKU, null, InputOption::VALUE_OPTIONAL, 'Search by SKU')
            ->addOption(self::OPTION_CATEGORY, null, InputOption::VALUE_OPTIONAL, 'Search by category')
            ->addOption(self::OPTION_PRICE_MIN, null, InputOption::VALUE_OPTIONAL, 'Search by min. price')
            ->addOption(self::OPTION_PRICE_MAX, null, InputOption::VALUE_OPTIONAL, 'Search by max. price')
            ->addOption(self::OPTION_IN_STOCK, null, InputOption::VALUE_OPTIONAL, 'Search by stock status')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = (new ClientFactory())->make();

        $result = $client->search(Data::fromArray($input->getOptions()));

        (new Table($output))
            ->setHeaders(['Title', 'SKU', 'Category', 'Price', 'In Stock'])
            ->setRows($this->makeTableRows($result))
            ->render()
        ;

        return self::SUCCESS;
    }

    private function makeTableRows(array $result): array
    {
        return array_map(function (array $hits): array {
            $src = $hits['_source'];

            $stock = array_sum(array_column($src['stock'], 'stock'));
            $inStock = $stock ? "Yes ($stock)" : 'No (0)';

            return [
                $src['title'],
                $src['sku'],
                $src['category'],
                $src['price'],
                $inStock
            ];
        }, $result['hits']['hits']);
    }
}
