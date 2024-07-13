<?php

declare(strict_types=1);

use Pyivanov\hw4\App;

require __DIR__ . '/../vendor/autoload.php';

try {
    (new App())->run();
} catch (Exception $e) {
    echo 'Код ' . $e->getCode() . ': ' . $e->getMessage();
}