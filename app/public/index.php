<?php

declare(strict_types=1);

use App\Base;

require __DIR__ . '/../vendor/autoload.php';

$emails = [
    "bob@example.com",
    "test@example.local",
    "invalidemail",
];

try {
    $app = new Base();
    echo "validated emails:<br>";
    foreach ($app->run($emails) as $key => $value) {
        echo $key . " => " . $value . "<br>";
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
