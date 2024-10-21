<?php

declare(strict_types=1);

namespace App\Controller\Console;

use App\Controller\Exception\SocketException;
use App\Domain\Service\ServerService;
use Generator;

class ServerController
{
    /**
     * @return Generator
     * @throws SocketException
     */
    public function run(): Generator
    {
        $serverService = new ServerService();
        yield $serverService->initializeChat();
        $serverService->beginChat();

        foreach ($serverService->keepChat() as $post) {
            yield $post;
        }

        foreach ($serverService->stopChat() as $post) {
            yield $post;
        }
    }
}
