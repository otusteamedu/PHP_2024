<?php

declare(strict_types=1);

namespace AlexanderPogorelov\ElasticSearch;

class Config
{
    public const INDEX_NAME = 'index_name';
    public const JSON_PATH = 'json_path';
    public const HOST = 'host';
    public const USERNAME = 'username';
    public const STOCK_BOOST_VALUE = 'stockBoostValue';
    public const STOCK_BOOST_SCORE = 'stockBoostScore';

    private array $data;

    /**
     * throws \RuntimeException
     */
    public function __construct()
    {
        $data = parse_ini_file(dirname(__DIR__) . '/config.ini');

        if (false === $data) {
            throw new \RuntimeException('Unable to parse config.ini');
        }

        $this->data = $data;
    }

    public function getIndexName(): string
    {
        return $this->data[self::INDEX_NAME];
    }

    public function getJsonPath(): string
    {
        return $this->data[self::JSON_PATH];
    }

    public function getHost(): string
    {
        return $this->data[self::HOST];
    }

    public function getUsername(): string
    {
        return $this->data[self::USERNAME];
    }

    public function getStockBoostValue(): int
    {
        return (int) $this->data[self::STOCK_BOOST_VALUE];
    }

    public function getStockBoostScore(): int
    {
        return (int) $this->data[self::STOCK_BOOST_SCORE];
    }

    public function getProperties(): array
    {
        return [
            'category' => [
                'type' => 'keyword',
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
                    'shop' => [
                        'type' => 'keyword',
                    ],
                    'stock' => [
                        'type' => 'short',
                    ],
                ],
            ],
            'title' => [
                'type' => 'text',
                'fields' => [
                    'keyword' => [
                        'type' => 'keyword',
                        'ignore_above' => 256,
                    ],
                ],
            ],
        ];
    }

    public function getSettings(): array
    {
        return [
            'analysis' => [
                'filter' => [
                    'ru_stop' => [
                        'type' => 'stop',
                        'stopwords' => '_russian_',
                    ],
                    'ru_stemmer' => [
                        'type' => 'stemmer',
                        'language' => 'russian',
                    ]
                ],
                'analyzer' => [
                    'my_russian' => [
                        'tokenizer' => 'standard',
                        'filter' => [
                            'lowercase',
                            'ru_stop',
                            'ru_stemmer',
                        ],
                    ],
                ],
            ],
        ];
    }
}
