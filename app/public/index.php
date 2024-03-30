<?php

declare(strict_types=1);

use Rmulyukov\Hw\App;
use Rmulyukov\Hw\Application\Factory\EventFactory;
use Rmulyukov\Hw\Config;
use Rmulyukov\Hw\ConsoleParams;

require_once __DIR__ . "/../vendor/autoload.php";

try {
    $config = new Config(require_once __DIR__ . "/../config/config.php");
    $params = new ConsoleParams($argv);
    $res = (new App(
        new EventFactory(),
        $config->getCommandRepository(),
        $config->getQueryRepository()
    ))->run($params);

    var_dump($res);
} catch (Throwable $throwable) {
    echo $throwable->getMessage();
}
