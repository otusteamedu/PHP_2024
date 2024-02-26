<?php

define("BASE_PATH", __DIR__);

$dirEnv = __DIR__ . '/../../';

// Composer
require($dirEnv . 'vendor/autoload.php');

try {
    $string = $argv[1] ?? '';

    $appService = new \hw6\AppService(new \hw6\EmailValidator());

    $data = explode(',', $string);
    foreach ($data as $value) {
        echo $value . ' - ' . $appService->validate((string)$value) . PHP_EOL;
    }
} catch (\Throwable $exception) {
    echo $exception->getMessage();
}
