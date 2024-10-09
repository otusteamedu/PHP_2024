<?php

require __DIR__ . '/vendor/autoload.php';

use Ali\App;

$app = new App($argv);

foreach ($app->getEmails() as $email) {
    echo "Email '$email' is " . $app->run($email) . PHP_EOL;
}
