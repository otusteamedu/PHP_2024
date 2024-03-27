<?php

declare(strict_types=1);

require_once "/app/vendor/autoload.php";

use Rmulyukov\Hw11\Application\App;
use Rmulyukov\Hw11\Application\Config;
use Rmulyukov\Hw11\Application\Query\ElasticQuery;
use Rmulyukov\Hw11\Repository\ShopCommandElasticRepository;
use Rmulyukov\Hw11\Repository\ShopQueryElasticRepository;

try {
    $config = new Config(require_once "/app/config/config.php");
    $app = new App(
        $config,
        new ShopCommandElasticRepository($config->getElasticHost()),
        new ShopQueryElasticRepository($config->getElasticHost(), new ElasticQuery())
    );
    return $app->run($argv);
} catch (Throwable $e) {
    echo $e->getMessage();
}
