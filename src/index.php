<?php

require __DIR__ . '/vendor/autoload.php';

use Ali\App;

$app = new App();

$emails = $argv;
array_shift($emails);

foreach ($emails as $email) {
    echo "Email '$email' is " . $app->run($email) . PHP_EOL;
}




