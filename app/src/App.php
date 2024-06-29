<?php

declare(strict_types=1);

namespace Kagirova\Hw31;

use Kagirova\Hw31\Application\ReceiverUseCase\ReceiveDataUseCase;
use Kagirova\Hw31\Domain\Config\Config;
use Kagirova\Hw31\Domain\Request;
use Kagirova\Hw31\Domain\Router;
use Kagirova\Hw31\Infrastucture\Database\PostgresStorage;
use Kagirova\Hw31\Infrastucture\Service\RabbitMqService;

class App
{
    public function run($arg)
    {
        $config = new Config();
        $service = new RabbitMqService('rabbit.channels.hw', $config);
        $postgres = new PostgresStorage($config);

        $useCase = match ($arg) {
            'sender' => $this->getUseCase($postgres, $service),
            'receiver' => new ReceiveDataUseCase($service, $postgres),
            default => throw new \Exception('Must have one argument: sender or receiver', 404)
        };

        $useCase->run();
        $service->close();
    }

    private function getUseCase(PostgresStorage $postgres, RabbitMqService $service)
    {
        $request = Request::capture();

        $router = new Router($request, $postgres, $service);
        return $router->resolve();
    }
}
