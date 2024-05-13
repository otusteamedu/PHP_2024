<?php

declare(strict_types=1);

namespace App;

use App\Chat\AdapterFactory;
use App\Config\SocketConfig;
use App\Exceptions\AppException;
use App\Network\SocketManager;

final class App
{
    public function run(): void
    {
        $adapterFactory = new AdapterFactory(
            new SocketManager(),
            new SocketConfig(),
        );

        $chat = $adapterFactory->make($this->getAdapterType());

        foreach ($chat->run() as $message) {
            echo $message . PHP_EOL;
        }
    }

    private function getAdapterType(): string
    {
        if ($_SERVER['argc'] !== 2) {
            throw AppException::wrongArgumentCount(2);
        }

        return strtolower(trim($_SERVER['argv'][1]));
    }
}
