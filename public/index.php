<?php

require_once '../vendor/autoload.php';

use AKornienko\Php2024\App;

$emails = [
    '1@gmail.com',
    '1@1.com',
    '1@gmail',
    '1@gmail.',
    '@gmail.com',
    'gmail.com',
    '1',
];

try {
    $app = new App();
    $messages = $app->run($emails);
    foreach ($messages as $message) {
        print_r($message . PHP_EOL);
    }
} catch (Exception $exception) {
    print_r($exception);
}
