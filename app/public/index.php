<?php

declare(strict_types=1);

use Rmulyukov\Hw\App;
use Rmulyukov\Hw\Application\UseCase\Publish\PublishUseCase;
use Rmulyukov\Hw\Config;
use Rmulyukov\Hw\Infrastructure\Service\RabbitMessageBusService;
use Rmulyukov\Hw\Request;

require_once __DIR__ . "/../vendor/autoload.php";

$config = new Config(require_once __DIR__ . '/../config/config.php');

try {
    $app = new App(
        new PublishUseCase(
            new RabbitMessageBusService(
                $config->getRabbitHost(),
                $config->getRabbitPort(),
                $config->getRabbitUsername(),
                $config->getRabbitPassword()
            )
        )
    );
    $app->run(new Request());
    echo "Message published";
} catch (Throwable $throwable) {
    echo $throwable->getMessage();
}