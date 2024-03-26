<?php

declare(strict_types=1);

namespace Lrazumov\Hw14;

class Output
{
    private array $result;

    public function __construct(array $result)
    {
        $this->result = $result;
    }

    public function output(): void
    {
        foreach ($this->result as $key => $item) {
            echo 'ID: ' . $item->_id . PHP_EOL;
            echo 'Title: ' . $item->_source->title . PHP_EOL;
            echo 'Sku: ' . $item->_source->sku . PHP_EOL;
            echo 'Category: ' . $item->_source->category . PHP_EOL;
            echo 'Price: ' . $item->_source->price . PHP_EOL;
            echo PHP_EOL;
        }
    }
}
