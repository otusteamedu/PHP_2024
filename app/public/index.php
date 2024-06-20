<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Orlov\Otus\App;

try {
    $app = (new App())();
} catch (Exception $e) {
    throw new Exception($e->getMessage());
}
