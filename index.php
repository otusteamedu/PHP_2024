<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$service = new \Sergey\OtusVasilkov\Application\StringService();
$command = new \Sergey\OtusVasilkov\Infrastructure\StringCommand($service);

$command->run();

