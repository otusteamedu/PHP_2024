<?php

declare(strict_types=1);

namespace Kagirova\Hw14;

use Kagirova\Hw14\Application\SearchUseCase;
use Kagirova\Hw14\Domain\Config;

class App
{
    public function run()
    {
        $config = new Config();
        $elastic = new Elastic(
            $config->getHost() . ':' . $config->getPort(),
            $config->getUser(),
            $config->getPassword()
        );

        $searchUseCase = new SearchUseCase($elastic);
        $searchUseCase->run();
    }
}
