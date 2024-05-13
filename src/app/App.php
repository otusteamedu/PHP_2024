<?php

declare(strict_types=1);

namespace App;

use App\Chat\AdapterFactory;
use App\Exceptions\AppException;

final class App
{
    public function run(): void
    {
        $chat = (new AdapterFactory())->make($this->getAdapterType());

        foreach ($chat->run() as $message) {
            echo $message . PHP_EOL;
        }
    }

    private function getAdapterType(): string
    {
        if ($_SERVER['argc'] !== 2) {
            throw AppException::wrongArgumentsCount(2);
        }

        return strtolower(trim($_SERVER['argv'][1]));
    }
}
