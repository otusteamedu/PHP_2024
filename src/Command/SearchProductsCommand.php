<?php

declare(strict_types=1);

namespace App\Command;

use App\Storage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SearchProductsCommand extends Command
{
    public function __construct(private readonly Storage $storageService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('app:search-products')
            ->setDescription('Поиск по продуктам')
            ->addOption(
                'title',
                null,
                InputOption::VALUE_OPTIONAL,
                'Поиск по названию'
            )
            ->addOption(
                'category',
                null,
                InputOption::VALUE_OPTIONAL,
                'Поиск по категории'
            )
            ->addOption(
                'sku',
                null,
                InputOption::VALUE_OPTIONAL,
                'Поиск по SKU'
            )
            ->addOption(
                'shop',
                null,
                InputOption::VALUE_OPTIONAL,
                'Поиск по магазину'
            )
            ->addOption(
                'min-price',
                null,
                InputOption::VALUE_OPTIONAL,
                'Минимальная цена'
            )
            ->addOption(
                'max-price',
                null,
                InputOption::VALUE_OPTIONAL,
                'Максимальная цена'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $params = [
            'index' => 'otus-shop',
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [],
                        'filter' => []
                    ]
                ]
            ]
        ];

        if ($input->getOption('title')) {
            $params['body']['query']['bool']['filter'][] = [
                'match' => ['title' => $input->getOption('title')]
            ];
        }

        if ($input->getOption('category')) {
            $params['body']['query']['bool']['filter'][] = [
                'match' => ['category' => $input->getOption('category')]
            ];
        }

        if ($input->getOption('sku')) {
            $params['body']['query']['bool']['filter'][] = [
                'match' => ['sku' => $input->getOption('sku')]
            ];
        }

        if ($input->getOption('shop')) {
            $params['body']['query']['bool']['filter'][] = [
                'nested' => [
                    'path' => 'stock',
                    'query' => [
                        'match' => ['stock.shop' => $input->getOption('shop')]
                    ]
                ]
            ];
        }

        if ($input->getOption('min-price')) {
            $params['body']['query']['bool']['filter'][] = [
                'range' => ['price' => ['gte' => $input->getOption('min-price')]]
            ];
        }

        if ($input->getOption('max-price')) {
            $params['body']['query']['bool']['filter'][] = [
                'range' => ['price' => ['lte' => $input->getOption('max-price')]]
            ];
        }

        $products = $this->storageService->search($params);

        if (empty($products)) {
            $output->writeln('Продукт не найден');
        } else {
            foreach ($products as $product) {
                $output->writeln(
                    sprintf(
                        "Продукт: %s - %s",
                        $product['_source']['title'],
                        $product['_source']['sku']
                    )
                );
            }
        }

        return Command::SUCCESS;
    }
}
