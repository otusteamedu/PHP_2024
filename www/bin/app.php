<?php

declare(strict_types=1);


require __DIR__ . '/../vendor/autoload.php';

$container = require_once __DIR__ . '/../app/container.php';

$app = new \App\Console\App(
    $container->get(\App\Application\Queue\QueueInterface::class),
    $container->get(\App\Infrastructure\ImageGenerator\BaseImageGenerator::class),
    $container->get(\Doctrine\ORM\EntityManagerInterface::class)
);

while (true) {
    try {
        $app->run();
    } catch (\Exception $e) {
        echo $e->getMessage() . PHP_EOL;
    }
    usleep(2000);
}
