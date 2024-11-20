<?php

declare(strict_types=1);

require '../vendor/autoload.php';
$ini = parse_ini_file('./app.ini');
use IraYu\Hw11;
(new Hw11\App(
    $_ENV['ELASTIC_HOST'],
    $_ENV['ELASTIC_PASSWORD'],
    $ini['es_index'] // Зависит от того, откуда мы испортировали индекс, если из контейнера php или вручную,
    // то app.ini подойдет, если из контейнера эластика, то будет $_ENV['ELASTIC_INDEX']
))->run(array_slice($argv, 1));
