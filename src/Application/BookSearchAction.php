<?php

declare(strict_types=1);


namespace Main\Application;

/**
 * Class BookSearchAction
 *
 * @property array $options Название индекса.
 */
class BookSearchAction
{
    protected $options;

    public function __construct()
    {
    }

    public function getAvailableOptions() :array
    {
        return [
            'title:',
            'category:',
            'minPrice:',
            'maxPrice:',
            'shopName:',
            'minStock:'
        ];
    }

    public function exec($options)
    {
        echo PHP_EOL;
        print_r($options);
        echo PHP_EOL;
    }
}