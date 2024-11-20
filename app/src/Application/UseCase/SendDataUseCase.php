<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Application\UseCase;

use Kagirova\Hw21\Infrastucture\Service\RabbitMqService;

class SendDataUseCase
{
    public function __construct(private RabbitMqService $service)
    {
    }

    public function run()
    {
        if (!array_key_exists('REQUEST_METHOD', $_SERVER) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new \Exception();
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $this->checkData($data);
        $this->service->publish($data);
    }

    private function checkData($data)
    {
        if (!isset($data['data'])) {
            throw new \Exception();
        }
    }
}
