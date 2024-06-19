<?php

declare(strict_types=1);

namespace Kagirova\Hw14;

use Kagirova\Hw14\Application\SearchUseCase;
use Kagirova\Hw14\Domain\Config;
use Kagirova\Hw14\Infrastructure\Elastic;

class App
{
    public function run()
    {
        $config = new Config();
        $elastic = new Elastic(
            $config->host . ':' . $config->port,
            $config->user,
            $config->password
        );

        $searchUseCase = new SearchUseCase($elastic);
        $searchUseCase->run();
    }
}
