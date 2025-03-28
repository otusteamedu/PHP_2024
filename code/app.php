<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use PavelMiasnov\VerificationEmailPhp\App;

$app = new App();

try {
    foreach ($app->run() as $item) {
        echo 'Result: ' . $item;
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
