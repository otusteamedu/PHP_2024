<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\SocketException;
use App\Service\ClientService;
use Generator;

class ClientController
{
    /**
     * @return Generator
     * @throws SocketException
     */
    public function run(): Generator
    {
        $clientService = new ClientService();
        $clientService->initializeChat();

        foreach ($clientService->keepChat() as $post) {
            yield $post;
        }

        foreach ($clientService->stopChat() as $post) {
            yield $post;
        }
    }
}
