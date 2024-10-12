<?php

declare(strict_types=1);

namespace App\Console\Command;

use App\Search\ClientFactory;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class InitializeCommand extends Command
{
    private const ARGUMENT_PATH = 'path';

    protected function configure(): void
    {
        $this
            ->setName('init')
            ->setDescription('Creates and initializes default search storage')
            ->addArgument(
                self::ARGUMENT_PATH,
                InputArgument::REQUIRED,
                'The absolute path to the file'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $client = (new ClientFactory())->make();

            $params = [
                'settings' => $this->getIndexSettings(),
                'mappings' => $this->getIndexMappings(),
            ];

            $client->createIndex(getenv('ES_INDEX_NAME'), $params);

            $payload = [
                'data-binary' => file_get_contents($input->getArgument(self::ARGUMENT_PATH)),
            ];

            $client->bulk($payload);

            return self::SUCCESS;
        } catch (Exception $e) {
            $output->writeln(sprintf('<error>Error: %s</error>', $e->getMessage()));

            return self::FAILURE;
        }
    }

    private function getIndexSettings(): array
    {
        return [
            'analysis' => [
                'filter' => [
                    'ru_stop' => ['type' => 'stop', 'stopwords' => '_russian_'],
                    'ru_stemmer' => ['type' => 'stemmer', 'language' => 'russian'],
                ],
                'analyzer' => [
                    'my_russian' => [
                        'tokenizer' => 'standard',
                        'filter' => ['lowercase', 'ru_stop', 'ru_stemmer'],
                    ],
                ],
            ],
        ];
    }

    private function getIndexMappings(): array
    {
        return [
            'properties' => [
                'category' => [
                    'type' => 'keyword',
                ],
                'title' => [
                    'type' => 'text',
                    'analyzer' => 'my_russian',
                    'fields' => [
                        'keyword' => [
                            'type' => 'keyword',
                            'ignore_above' => 256,
                        ],
                    ],
                ],
                'sku' => [
                    'type' => 'keyword',
                ],
                'price' => [
                    'type' => 'integer',
                ],
                'stock' => [
                    'type' => 'nested',
                    'properties' => [
                        'shop' => ['type' => 'keyword'],
                        'stock' => ['type' => 'integer'],
                    ],
                ],
            ]
        ];
    }
}
