<?php

declare(strict_types=1);

require_once __DIR__ . "/../vendor/autoload.php";

try {
    $dotenv = \Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . "/..");
    $dotenv->load();
    $config = [];
    if (file_exists(__DIR__ . "/../config.php")) {
        $config = include __DIR__ . "/../config.php";
    }

    $app = \App\Infrastructure\Main\Console\Application::getInstance($config);
    $options = getopt('', [
        'action::'
    ]);
    $app->initAction($options);
    $availableOptions = $app->getActionAvailableOptions();

    $options = getopt('', $availableOptions);

    $app->runAction($options);
} catch (\Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}
