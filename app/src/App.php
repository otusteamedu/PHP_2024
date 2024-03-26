<?php

declare(strict_types=1);

namespace Lrazumov\Hw14;

class App
{
    private array $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function run()
    {
        $query = (new Query($this->options))
            ->getQuery();
        $result = (new Elastic($query))
            ->search();
        (new Output($result))
            ->output();
    }
}
