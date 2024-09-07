<?php

declare(strict_types=1);

require '../vendor/autoload.php';

use IraYu\Hw11;
(new Hw11\App(
    $_ENV['ELASTIC_HOST'],
    $_ENV['ELASTIC_PASSWORD']
))->run(array_slice($argv, 1));
