<?php

namespace Komarov\Hw5\App;

use Komarov\Hw5\Exception\AppException;

class App
{
    /**
     * @throws AppException
     */
    public function run(): void
    {
        $type = $_SERVER['argv'][1] ?? null;

        match ($type) {
            'server' => (new Server())->start(),
            'client' => (new Client())->start(),
            default => throw new AppException('Unknown application type'),
        };
    }
}
