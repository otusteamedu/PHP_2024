<?php

declare(strict_types=1);

namespace Hinoho\Battleship;

use Hinoho\Battleship\Application\SenderUseCase\StartUseCase;
use Hinoho\Battleship\Domain\Config\Config;
use Hinoho\Battleship\Infrastucture\Database\PostgresStorage;

class App
{
    public function run()
    {
        $config = new Config();
        $postgres = new PostgresStorage($config);

        $useCase = new StartUseCase($postgres);

        $useCase->run();
    }
}
