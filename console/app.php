<?php

declare(strict_types=1);


require_once __DIR__ . "/../vendor/autoload.php";

try {

    $options = getopt('', [
    'title:',
    'category:',
    'minPrice:',
    'maxPrice:',
    'shopName:',
    'minStock:'
]);
       var_dump($options);
    $dotenv = \Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . "/..");
    $dotenv->load();

    if (file_exists(__DIR__ . "/../config.php")) {
        $config = include __DIR__ . "/../config.php";
    }

    $app = Main\Application\BookSearchConsoleApp::getInstance($config);

    $app->initAction($argv);
    $availableOptions = $app->getActionAvailableOptions();

// Получаем параметры командной строки и передаем их в приложение

    $app->runAction($options);

} catch (\Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}