<?php

declare(strict_types=1);

namespace Kagirova\Hw21;

use Kagirova\Hw21\Application\UseCase\ReceiveDataUseCase;
use Kagirova\Hw21\Application\UseCase\SendDataUseCase;
use Kagirova\Hw21\Domain\Config\Config;
use Kagirova\Hw21\Infrastucture\Service\RabbitMqService;

class App
{
    public function run($arg)
    {
        $config = new Config();
        $service = new RabbitMqService('rabbit.channels.hw', $config);

        $useCase = match ($arg) {
            'sender' => new SendDataUseCase($service),
            'receiver' => new ReceiveDataUseCase($service),
            default => throw new \Exception('Must have one argument: client or server')
        };

        $useCase->run();
    }
}
