<?php

declare(strict_types=1);

use Ahar\Hw6\App;

require '../vendor/autoload.php';

$app = new App();

try {
    foreach ($app->run(['email@example.com', 'facebook@facebook.com', 'twitter@t.com', 'invalid']) as $email => $status) {
        echo "{$email}: " . ($status ? 'valid' : 'not valid') . "<br />";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
