<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use TimurShakirov\EmailValidator\App;

$app = new App();

try {
    $app->run('./src/emails.txt');
} catch (Exception $e) {
    echo $e->getMessage();
}
