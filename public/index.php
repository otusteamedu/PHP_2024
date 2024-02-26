<?php

declare(strict_types=1);

use Afilipov\Hw6\App;

require '../vendor/autoload.php';

try {
    $app = new App();
    foreach ($app->run() as $email => $isValid) {
        echo "$email - " . ($isValid ? 'валидный' : 'не валидный') . '<br/>';
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
