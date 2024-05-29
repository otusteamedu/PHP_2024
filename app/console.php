<?php

declare(strict_types=1);

use Rmulyukov\Hw\Application\UseCase\Consume\ConsumeUseCase;
use Rmulyukov\Hw\Config;
use Rmulyukov\Hw\ConsoleApp;
use Rmulyukov\Hw\Infrastructure\Service\RabbitMessageBusService;

require_once __DIR__ . "/vendor/autoload.php";

$config = new Config(require_once __DIR__ . '/config/config.php');

try {
    $app = new ConsoleApp(
        new ConsumeUseCase(
            new RabbitMessageBusService(
                $config->getRabbitHost(),
                $config->getRabbitPort(),
                $config->getRabbitUsername(),
                $config->getRabbitPassword()
            )
        )
    );
    $app->run();
} catch (Throwable $throwable) {
    echo $throwable->getMessage();
}
