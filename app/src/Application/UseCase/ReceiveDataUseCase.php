<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Application\UseCase;

use Kagirova\Hw21\Infrastucture\Service\RabbitMqService;

class ReceiveDataUseCase
{
    public function __construct(private RabbitMqService $service)
    {
    }

    public function run()
    {
        $this->service->consume();
    }
}
